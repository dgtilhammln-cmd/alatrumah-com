<?php
$file = 'C:/Users/dgtil/Downloads/PENTING/HVM Digital/CLIENT Local WEB & Deploy/alatrumah.com ex cyclevent/app/Models/Service.php';
$content = file_get_contents($file);
$hasCrlf = str_contains($content, "\r\n");
echo "Has CRLF: " . ($hasCrlf ? 'yes' : 'no') . "\n";

