<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $newNumber = '085735180390';
        $newNumberInt = '6285735180390';

        // 1. Update wa_settings table
        if (Schema::hasTable('wa_settings')) {
            // Update any record referencing the old number
            DB::table('wa_settings')
                ->where('nomor_wa', 'like', '%81216621307%')
                ->update(['nomor_wa' => $newNumberInt]);

            // If any record has empty nomor_wa, set it
            DB::table('wa_settings')
                ->where(function ($q) {
                    $q->whereNull('nomor_wa')->orWhere('nomor_wa', '');
                })
                ->update(['nomor_wa' => $newNumberInt]);

            // Ensure at least one primary active WA exists
            $exists = DB::table('wa_settings')->where('is_active', true)->exists();
            if (!$exists) {
                DB::table('wa_settings')->insert([
                    'label'          => 'CS Alat Rumah',
                    'nomor_wa'       => $newNumberInt,
                    'template_pesan' => "Halo Alatrumah.com! 👋\n\nSaya tertarik dengan produk: *[nama produk]*\n\nBoleh minta info lebih lanjut? Terima kasih! 🙏",
                    'is_active'      => 1,
                    'is_primary'     => 1,
                    'order'          => 1,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        // 2. Update settings table
        if (Schema::hasTable('settings')) {
            DB::table('settings')
                ->where('value', 'like', '%81216621307%')
                ->update(['value' => $newNumber]);

            // Update specific keys if they exist
            DB::table('settings')
                ->whereIn('key', ['wa1', 'contact_wa', 'contact.wa', 'whatsapp', 'phone_wa'])
                ->update(['value' => $newNumber]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversible if needed
    }
};
