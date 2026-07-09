<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$migrations = DB::select("SELECT * FROM migrations");
foreach($migrations as $m) echo $m->migration . "\n";
