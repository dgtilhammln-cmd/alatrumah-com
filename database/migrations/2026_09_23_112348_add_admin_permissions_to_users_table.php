<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk menyimpan permission yang diizinkan (JSON array)
            $table->json('admin_permissions')->nullable()->after('role');
        });

        // Jadikan admin pertama (ID terkecil) sebagai super_admin
        // agar tidak terkunci dari sistem
        $firstAdmin = DB::table('users')
            ->where('role', 'admin')
            ->orderBy('id')
            ->first();

        if ($firstAdmin) {
            DB::table('users')
                ->where('id', $firstAdmin->id)
                ->update(['role' => 'super_admin']);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin_permissions');
        });

        // Kembalikan super_admin menjadi admin
        DB::table('users')
            ->where('role', 'super_admin')
            ->update(['role' => 'admin']);
    }
};
