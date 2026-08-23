<?php
$data = json_decode(file_get_contents('parsed_data.json'), true);
$products = $data['products'];

// Column index mapping based on actual schema:
// [0]=id [1]=sku [2]=barcode [3]=name [4]=slug [5]=category_id
// [6]=description_short [7]=description_long [8]=has_variant
// [9]=base_price [10]=sale_price [11]=weight [12]=views_count
// [13]=is_active [14]=with_stock [15]=created_at [16]=updated_at

function cleanVal($val) {
    if ($val === 'NULL') return null;
    if (str_starts_with($val, "'") && str_ends_with($val, "'")) {
        $val = substr($val, 1, -1);
    }
    return $val;
}

echo "=== ALL PRODUCTS: ID | SKU | NAME | BASE_PRICE | SALE_PRICE | IS_ACTIVE | WITH_STOCK ===\n\n";
foreach ($products as $row) {
    $id = cleanVal($row[0]);
    $sku = cleanVal($row[1]);
    $name = cleanVal($row[3]);
    $basePrice = cleanVal($row[9]);
    $salePrice = cleanVal($row[10]);
    $isActive = cleanVal($row[13]);
    $withStock = cleanVal($row[14]);

    $flag = ((float)$basePrice === 0.0 || $basePrice === null) ? ' <-- HARGA 0/NULL!' : '';
    echo "ID:$id | SKU:$sku | Price:$basePrice | Sale:$salePrice | Active:$isActive | WithStock:$withStock$flag\n";
    echo "  Name: $name\n\n";
}
