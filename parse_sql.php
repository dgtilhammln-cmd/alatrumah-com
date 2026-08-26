<?php

$sql = file_get_contents('u947770498_hub.sql');

function extractInsert($sql, $table) {
    preg_match("/INSERT INTO \`$table\` \([^)]+\) VALUES\s*(.*?);/s", $sql, $matches);
    if (empty($matches)) return [];
    
    $valuesStr = $matches[1];
    
    // Split by ),( but be careful about strings containing it
    // A simple state machine is best
    $len = strlen($valuesStr);
    $inString = false;
    $escape = false;
    $currentRow = [];
    $currentVal = "";
    $rows = [];
    
    for ($i = 0; $i < $len; $i++) {
        $c = $valuesStr[$i];
        
        if ($escape) {
            $currentVal .= $c;
            $escape = false;
            continue;
        }
        
        if ($c === '\\') {
            $currentVal .= $c;
            $escape = true;
            continue;
        }
        
        if ($c === "'") {
            $inString = !$inString;
            $currentVal .= $c;
            continue;
        }
        
        if (!$inString) {
            if ($c === '(' && empty($currentVal)) {
                // start of row
                continue;
            } elseif ($c === ',') {
                $currentRow[] = trim($currentVal);
                $currentVal = "";
            } elseif ($c === ')') {
                $currentRow[] = trim($currentVal);
                $rows[] = $currentRow;
                $currentRow = [];
                $currentVal = "";
                
                // skip to next '('
                while ($i + 1 < $len && $valuesStr[$i+1] !== '(') {
                    $i++;
                }
            } else {
                $currentVal .= $c;
            }
        } else {
            $currentVal .= $c;
        }
    }
    
    return $rows;
}

$products = extractInsert($sql, 'products');
$images = extractInsert($sql, 'product_images');

$data = [
    'products' => $products,
    'images' => $images
];

file_put_contents('parsed_data.json', json_encode($data, JSON_PRETTY_PRINT));
echo "Parsed " . count($products) . " products and " . count($images) . " images\n";
