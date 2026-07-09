<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$compiler = app('blade.compiler');
$compiled = $compiler->compileString(file_get_contents(__DIR__ . '/resources/views/services/show.blade.php'));
file_put_contents(__DIR__ . '/temp_compiled.php', $compiled);
echo "Compiled to temp_compiled.php";
