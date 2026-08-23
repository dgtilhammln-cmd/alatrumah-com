<?php
$sql = file_get_contents('u947770498_hub.sql');

// Extract CREATE TABLE products
if (preg_match('/CREATE TABLE `products` \((.*?)\) ENGINE/s', $sql, $m)) {
    echo "=== PRODUCTS TABLE COLUMNS ===\n";
    echo $m[1] . "\n\n";
} else {
    echo "products table not found\n";
}

// Also show first 2 rows of products to crosscheck
if (preg_match('/INSERT INTO `products` \(([^)]+)\)/', $sql, $cols)) {
    echo "=== INSERT COLUMNS ===\n";
    echo $cols[1] . "\n\n";
    
    // Number them
    $columns = explode(',', $cols[1]);
    echo "=== NUMBERED COLUMNS ===\n";
    foreach ($columns as $i => $col) {
        echo "[$i] = " . trim($col) . "\n";
    }
}
