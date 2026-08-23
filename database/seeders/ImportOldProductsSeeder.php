<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ImportOldProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = base_path('parsed_data.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("File parsed_data.json not found!");
            return;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        $products = $data['products'] ?? [];
        $images = $data['images'] ?? [];

        // Organize images by product_id
        $productImages = [];
        foreach ($images as $imgRow) {
            if (count($imgRow) < 6) continue;
            
            $productId = $this->cleanValue($imgRow[1]);
            $imagePath = $this->cleanValue($imgRow[2]);
            $isPrimary = $this->cleanValue($imgRow[3]) == '1';
            
            if (!isset($productImages[$productId])) {
                $productImages[$productId] = ['primary' => null, 'gallery' => []];
            }
            
            if ($isPrimary) {
                $productImages[$productId]['primary'] = $imagePath;
            } else {
                $productImages[$productId]['gallery'][] = $imagePath;
            }
        }

        // Ensure category exists
        if (ProductCategory::count() === 0) {
            ProductCategory::create([
                'name' => 'General',
                'slug' => 'general',
                'is_active' => true,
            ]);
        }
        $defaultCat = ProductCategory::first()->id;

        DB::beginTransaction();
        try {
            foreach ($products as $row) {
                if (count($row) < 17) continue;

                $id = $this->cleanValue($row[0]);
                $sku = $this->cleanValue($row[1]);
                $name = $this->cleanValue($row[3]);
                $slug = $this->cleanValue($row[4]);
                $catId = (int) $this->cleanValue($row[5]);
                $shortDesc = $this->cleanValue($row[6]);
                $desc = $this->cleanValue($row[7]);
                $basePrice = (float) $this->cleanValue($row[9]);
                $salePrice = (float) $this->cleanValue($row[10]);
                $weight = (int) $this->cleanValue($row[11]);
                $isActive = $this->cleanValue($row[13]) == '1';
                $createdAt = $this->cleanValue($row[15]);

                // Ensure category exists
                if (!ProductCategory::where('id', $catId)->exists()) {
                    ProductCategory::create([
                        'id' => $catId,
                        'name' => 'Category ' . $catId,
                        'slug' => 'category-' . $catId,
                        'is_active' => true,
                    ]);
                }

                $primaryImg = $productImages[$id]['primary'] ?? null;
                $gallery = $productImages[$id]['gallery'] ?? [];

                // If no primary image but gallery has images, use the first one
                if (!$primaryImg && count($gallery) > 0) {
                    $primaryImg = array_shift($gallery);
                }

                Service::updateOrCreate(
                    ['sku' => $sku],
                    [
                        'name' => $name,
                        'slug' => $slug,
                        'short_desc' => $shortDesc,
                        'description' => $desc,
                        'product_category_id' => $catId,
                        'type' => 'product',
                        'price' => $basePrice,
                        'sale_price' => $salePrice > 0 ? $salePrice : null,
                        'weight' => $weight,
                        'is_active' => $isActive,
                        'image' => $primaryImg ? 'uploads/products/' . $primaryImg : null,
                        'gallery' => array_map(function($g) { return 'uploads/products/' . $g; }, $gallery),
                        'stock' => 100, // Default stock as it wasn't clearly exported in stock column (used with_stock)
                        'min_order' => 1,
                        'created_at' => $createdAt !== 'NULL' ? $createdAt : now(),
                        'updated_at' => now(),
                    ]
                );
            }
            DB::commit();
            $this->command->info("Successfully imported " . count($products) . " products!");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Failed to import products: " . $e->getMessage());
        }
    }

    private function cleanValue($val)
    {
        if ($val === 'NULL') return null;
        // Strip single quotes at start and end
        if (str_starts_with($val, "'") && str_ends_with($val, "'")) {
            $val = substr($val, 1, -1);
        }
        // Unescape internal single quotes
        $val = str_replace("\\'", "'", $val);
        // Unescape newlines
        $val = str_replace(['\r', '\n'], ["\r", "\n"], $val);
        
        return $val;
    }
}
