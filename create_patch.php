<?php
$files = [
    'app/Http/Controllers/LeadController.php',
    'app/Models/Lead.php',
    'bootstrap/app.php',
    'database/migrations/2026_06_14_133400_add_utm_columns_to_leads_table.php',
    'app/Http/Middleware/CaptureUtmMiddleware.php',
    'resources/views/admin/leads/show.blade.php'
];

$zip = new ZipArchive();
if ($zip->open('patch.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach ($files as $file) {
        if (file_exists($file)) {
            $zip->addFile($file, $file);
            echo "Added $file\n";
        } else {
            echo "Missing $file\n";
        }
    }
    $zip->close();
    echo "Successfully created patch.zip\n";
} else {
    echo "Failed to create zip file\n";
}
