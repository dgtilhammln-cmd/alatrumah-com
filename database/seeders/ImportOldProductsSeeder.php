<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\ProductCategory;

class ImportOldProductsSeeder extends Seeder
{
    /**
     * Column mapping from old `products` table:
     * [0]=id [1]=sku [2]=barcode [3]=name [4]=slug [5]=category_id
     * [6]=description_short [7]=description_long [8]=has_variant
     * [9]=base_price [10]=sale_price [11]=weight [12]=views_count
     * [13]=is_active [14]=with_stock [15]=created_at [16]=updated_at
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
        $images   = $data['images']   ?? [];

        // Organize images by old product_id
        $productImages = [];
        foreach ($images as $imgRow) {
            if (count($imgRow) < 6) continue;
            $oldProductId = $this->clean($imgRow[1]);
            $imagePath    = $this->clean($imgRow[2]);
            $isPrimary    = $this->clean($imgRow[3]) == '1';

            if (!isset($productImages[$oldProductId])) {
                $productImages[$oldProductId] = ['primary' => null, 'gallery' => []];
            }
            if ($isPrimary) {
                $productImages[$oldProductId]['primary'] = $imagePath;
            } else {
                $productImages[$oldProductId]['gallery'][] = $imagePath;
            }
        }

        DB::beginTransaction();
        try {
            $imported = 0;
            foreach ($products as $row) {
                if (count($row) < 16) continue;

                $id         = $this->clean($row[0]);
                $sku        = $this->clean($row[1]);
                $name       = $this->clean($row[3]);
                $slug       = $this->clean($row[4]);
                $catId      = (int) $this->clean($row[5]);
                $shortDesc  = $this->clean($row[6]);
                $desc       = $this->clean($row[7]);
                $basePrice  = $this->clean($row[9]);   // base_price
                $salePrice  = $this->clean($row[10]);  // sale_price
                $weight     = (int) ($this->clean($row[11]) ?? 0); // weight in gram
                $isActive   = $this->clean($row[13]) == '1';       // is_active
                $createdAt  = $this->clean($row[15]);

                // Ensure price is numeric — if NULL/empty, default to 0 but still type=product
                $basePrice = ($basePrice !== null && $basePrice !== '') ? (float) $basePrice : 0;
                $salePrice = ($salePrice !== null && $salePrice !== '') ? (float) $salePrice : null;

                // Ensure category exists
                if ($catId > 0 && !ProductCategory::where('id', $catId)->exists()) {
                    ProductCategory::create([
                        'id'        => $catId,
                        'name'      => 'Kategori ' . $catId,
                        'slug'      => 'kategori-' . $catId,
                        'is_active' => true,
                    ]);
                }

                // Images
                $primaryImg = $productImages[$id]['primary'] ?? null;
                $gallery    = $productImages[$id]['gallery'] ?? [];
                if (!$primaryImg && count($gallery) > 0) {
                    $primaryImg = array_shift($gallery);
                }

                Service::updateOrCreate(
                    ['sku' => $sku],
                    [
                        'name'                => $name,
                        'slug'                => $slug,
                        'short_desc'          => $shortDesc,
                        'description'         => $desc,
                        'product_category_id' => $catId ?: null,
                        'type'                => 'product',  // ALWAYS product
                        'price'               => $basePrice,
                        'sale_price'          => ($salePrice > 0) ? $salePrice : null,
                        'weight'              => $weight,
                        'is_active'           => $isActive,
                        'is_featured'         => false,
                        'image'               => $primaryImg ? 'services/produk-lama/' . $primaryImg : null,
                        'gallery'             => array_map(fn($g) => 'services/produk-lama/' . $g, $gallery),
                        'stock'               => 50,
                        'min_order'           => 1,
                        'created_at'          => ($createdAt && $createdAt !== 'NULL') ? $createdAt : now(),
                        'updated_at'          => now(),
                    ]
                );
                $imported++;
            }
            DB::commit();
            $this->command->info("Berhasil import $imported produk!");

            // Summary of products with price=0
            $zeroPrice = Service::where('type', 'product')->where('price', 0)->get(['id', 'sku', 'name']);
            if ($zeroPrice->count() > 0) {
                $this->command->warn("Produk dengan harga 0 (perlu update manual):");
                foreach ($zeroPrice as $p) {
                    $this->command->line("  - [{$p->sku}] {$p->name}");
                }
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Gagal import: " . $e->getMessage());
            $this->command->line("File: " . $e->getFile() . ":" . $e->getLine());
        }
    }

    private function clean($val): ?string
    {
        if ($val === 'NULL') return null;
        if (str_starts_with($val, "'") && str_ends_with($val, "'")) {
            $val = substr($val, 1, -1);
        }
        $val = str_replace("\\'", "'", $val);
        $val = str_replace(['\r\n', '\r', '\n'], ["\r\n", "\r", "\n"], $val);
        return $val;
    }
}
