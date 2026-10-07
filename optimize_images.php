<?php

$dirs = [
    __DIR__ . '/storage/app/public',
    __DIR__ . '/public/storage'
];

$totalOriginal = 0;
$totalCompressed = 0;
$count = 0;

echo "=== STARTING IMAGE OPTIMIZATION ===" . PHP_EOL;

foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isDir()) continue;
        
        $path = $file->getPathname();
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($ext, ['webp', 'jpg', 'jpeg', 'png'])) continue;

        $size = filesize($path);
        if ($size < 50 * 1024) continue; // Skip images already under 50KB

        $totalOriginal += $size;
        $img = null;

        if ($ext === 'webp') {
            if (function_exists('imagecreatefromwebp')) {
                @$img = imagecreatefromwebp($path);
            }
        } elseif ($ext === 'jpeg' || $ext === 'jpg') {
            @$img = imagecreatefromjpeg($path);
        } elseif ($ext === 'png') {
            @$img = imagecreatefrompng($path);
        }

        if (!$img) continue;

        $w = imagesx($img);
        $h = imagesy($img);

        // Max dimensions
        $maxW = 1200;
        $maxH = 1200;

        if ($w > $maxW || $h > $maxH) {
            $ratio = min($maxW / $w, $maxH / $h);
            $newW = (int) round($w * $ratio);
            $newH = (int) round($h * $ratio);

            $resized = imagecreatetruecolor($newW, $newH);
            if ($ext === 'png' || $ext === 'webp') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }
            imagecopyresampled($resized, $img, 0, 0, 0, 0, $newW, $newH, $w, $h);
            imagedestroy($img);
            $img = $resized;
        }

        // Save back with 78% quality WebP
        if (function_exists('imagewebp')) {
            imagewebp($img, $path, 78);
        }
        imagedestroy($img);

        clearstatcache(true, $path);
        $newSize = filesize($path);
        $totalCompressed += $newSize;
        $count++;

        $origKB = round($size / 1024, 1);
        $newKB = round($newSize / 1024, 1);
        $savedPercent = round((($size - $newSize) / $size) * 100, 1);
        echo "Optimized [{$file->getFilename()}]: {$origKB} KB -> {$newKB} KB (Saved {$savedPercent}%)" . PHP_EOL;
    }
}

$origMB = round($totalOriginal / (1024 * 1024), 2);
$compMB = round($totalCompressed / (1024 * 1024), 2);
$savedMB = round(($totalOriginal - $totalCompressed) / (1024 * 1024), 2);

echo "=== SUMMARY ===" . PHP_EOL;
echo "Optimized {$count} images." . PHP_EOL;
echo "Original Total: {$origMB} MB" . PHP_EOL;
echo "Compressed Total: {$compMB} MB" . PHP_EOL;
echo "Total Savings: {$savedMB} MB" . PHP_EOL;
