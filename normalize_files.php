<?php
$createFile = 'C:/Users/dgtil/Downloads/PENTING/HVM Digital/CLIENT Local WEB & Deploy/alatrumah.com ex cyclevent/resources/views/admin/services/create.blade.php';
$editFile   = 'C:/Users/dgtil/Downloads/PENTING/HVM Digital/CLIENT Local WEB & Deploy/alatrumah.com ex cyclevent/resources/views/admin/services/edit.blade.php';

function normalizeFile($path) {
    $c = file_get_contents($path);
    $c = str_replace("\r\n", "\n", $c);
    file_put_contents($path, $c);
}

normalizeFile($createFile);
normalizeFile($editFile);
echo "Normalized line endings to LF\n";

