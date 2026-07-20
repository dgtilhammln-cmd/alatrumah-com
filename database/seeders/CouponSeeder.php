<?php

namespace Database\Seeders;

use App\Enums\CouponType;
use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Seed kupon dummy untuk testing dan promosi awal.
     */
    public function run(): void
    {
        $coupons = [
            // Kupon selamat datang: diskon 10% maksimal Rp 100.000
            [
                'code'         => 'WELCOME10',
                'type'         => CouponType::Percentage->value,
                'value'        => 10.00,
                'min_purchase' => 200000.00,   // Minimal belanja Rp 200.000
                'max_discount' => 100000.00,   // Maksimal potongan Rp 100.000
                'usage_limit'  => null,        // Tidak terbatas
                'used_count'   => 0,
                'is_active'    => true,
                'started_at'   => now(),
                'expired_at'   => now()->addYear(),
            ],
            // Kupon diskon nominal: potongan Rp 50.000
            [
                'code'         => 'DISKON50K',
                'type'         => CouponType::Fixed->value,
                'value'        => 50000.00,
                'min_purchase' => 500000.00,   // Minimal belanja Rp 500.000
                'max_discount' => null,         // Tidak ada batas (karena fixed)
                'usage_limit'  => 100,         // Maksimal 100x pemakaian total
                'used_count'   => 0,
                'is_active'    => true,
                'started_at'   => now(),
                'expired_at'   => now()->addMonths(6),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(
                ['code' => $coupon['code']],
                array_merge($coupon, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('✅ CouponSeeder: ' . count($coupons) . ' kupon berhasil dibuat.');
        $this->command->table(
            ['Kode', 'Tipe', 'Nilai', 'Min. Belanja', 'Kadaluarsa'],
            collect($coupons)->map(fn($c) => [
                $c['code'],
                $c['type'],
                $c['type'] === CouponType::Percentage->value
                    ? $c['value'] . '%'
                    : 'Rp ' . number_format($c['value'], 0, ',', '.'),
                'Rp ' . number_format($c['min_purchase'], 0, ',', '.'),
                $c['expired_at']->format('d M Y'),
            ])->toArray()
        );
    }
}
