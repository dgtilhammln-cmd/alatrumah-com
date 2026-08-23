<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAlatrumahIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@alatrumah.id'],
            [
                'name' => 'Super Admin Alatrumah.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $this->command->info('Berhasil membuat/update akun admin:');
        $this->command->info('Email: ' . $user->email);
        $this->command->info('Password: password123');
        $this->command->warn('Mohon segera login dan ganti password default tersebut.');
    }
}
