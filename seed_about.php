<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

$defaults = [
    'about_heading' => 'A global consulting partner dedicated to building <span class="ab-icon-blue"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg></span> smarter and <span class="ab-icon-green"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3c-4.97 0-9 4.03-9 9 0 3.18 1.66 6.02 4.14 7.69.41.27.68.73.68 1.22V22h8.36v-1.09c0-.49.27-.95.68-1.22 2.48-1.67 4.14-4.51 4.14-7.69 0-4.97-4.03-9-9-9zM12 18h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg></span> more adaptive',
    'about_c1_title' => 'Continents',
    'about_c1_val' => '20+',
    'about_c2_title' => 'Commitment to measurable',
    'about_c2_val' => '100%',
    'about_c2_desc' => 'Collaborating with leading AI and cloud technology providers.',
    'about_c3_val' => '120+',
    'about_c3_desc' => 'Collaborating with leading AI and cloud technology providers.',
    'about_c4_title' => 'Data Points',
    'about_c4_val' => '520k+',
    'about_c4_desc' => 'Analyzed monthly to power smarter business strategies.',
];

foreach ($defaults as $key => $val) {
    if (!Setting::where('key', $key)->exists()) {
        Setting::set($key, $val, 'text');
    }
}
Setting::clearCache();
echo "Default about settings seeded successfully!\n";
