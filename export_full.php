<?php
// Export ALL data from local SQLite for import to Hostinger MySQL
$db = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";

// Helper: escape string for MySQL
function esc($val) {
    if ($val === null) return 'NULL';
    return "'" . addslashes($val) . "'";
}

// Tables to export (order matters for FK)
$tables = [
    'users', 'wa_settings', 'settings', 'services',
    'gallery_projects', 'articles', 'clients',
    'testimonials', 'hero_slides', 'leads', 'analytics_events'
];

foreach ($tables as $table) {
    try {
        $rows = $db->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rows)) continue;

        $sql .= "-- TABLE: $table (" . count($rows) . " rows)\n";
        $sql .= "DELETE FROM `$table`;\n";

        foreach ($rows as $row) {
            $cols = implode(', ', array_map(fn($c) => "`$c`", array_keys($row)));
            $vals = implode(', ', array_map(fn($v) => esc($v), array_values($row)));
            $sql .= "INSERT INTO `$table` ($cols) VALUES ($vals);\n";
        }
        $sql .= "\n";
        echo "Exported $table: " . count($rows) . " rows\n";
    } catch (Exception $e) {
        echo "SKIP $table: " . $e->getMessage() . "\n";
    }
}

$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

$outPath = __DIR__ . '/full_restore.sql';
file_put_contents($outPath, $sql);
echo "\nDone! File: full_restore.sql (" . round(filesize($outPath)/1024, 1) . " KB)\n";
