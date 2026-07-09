<?php
$db = new PDO('sqlite:C:\Users\dgtil\Downloads\[PENTING]\HVM Digital\CLONE KPT\database\database.sqlite');
$settings = $db->query("SELECT `key`, `value` FROM settings WHERE type = 'image' AND `value` IS NOT NULL AND `value` != ''")->fetchAll(PDO::FETCH_ASSOC);
$clients = $db->query("SELECT id, name, logo FROM clients WHERE logo IS NOT NULL AND logo != ''")->fetchAll(PDO::FETCH_ASSOC);
$heroes = $db->query("SELECT id, image FROM hero_slides WHERE image IS NOT NULL AND image != ''")->fetchAll(PDO::FETCH_ASSOC);

$sql = "";
foreach($settings as $s) {
    $sql .= "UPDATE settings SET value = '" . $s['value'] . "' WHERE `key` = '" . $s['key'] . "';\n";
}
foreach($clients as $c) {
    $sql .= "UPDATE clients SET logo = '" . $c['logo'] . "' WHERE name = '" . str_replace("'", "''", $c['name']) . "';\n";
}
foreach($heroes as $h) {
    // We don't have titles in hero_slides by default in the old seeder, so maybe match by ID
    $sql .= "UPDATE hero_slides SET image = '" . $h['image'] . "' WHERE id = " . $h['id'] . ";\n";
}
file_put_contents('c:\Users\dgtil\Downloads\[PENTING]\HVM Digital\CLONE KPT\restore_images_2.sql', $sql);
echo 'Generated ' . count($settings) . ' settings, ' . count($clients) . ' clients, and ' . count($heroes) . ' hero updates.';
