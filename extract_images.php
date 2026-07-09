<?php
$db = new PDO('sqlite:C:\Users\dgtil\Downloads\[PENTING]\HVM Digital\CLONE KPT\database\database.sqlite');
$services = $db->query("SELECT slug, image FROM services WHERE image IS NOT NULL AND image != ''")->fetchAll(PDO::FETCH_ASSOC);
$galleries = $db->query("SELECT id, image FROM gallery_projects WHERE image IS NOT NULL AND image != ''")->fetchAll(PDO::FETCH_ASSOC);

$sql = "";
foreach($services as $s) {
    $sql .= "UPDATE services SET image = '" . $s['image'] . "' WHERE slug = '" . $s['slug'] . "';\n";
}
foreach($galleries as $g) {
    $sql .= "UPDATE gallery_projects SET image = '" . $g['image'] . "' WHERE id = " . $g['id'] . ";\n";
}
file_put_contents('c:\Users\dgtil\Downloads\[PENTING]\HVM Digital\CLONE KPT\restore_images.sql', $sql);
echo 'Generated ' . count($services) . ' services and ' . count($galleries) . ' gallery updates.';
