<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::updateOrCreate(
            ['email' => 'admin@smartpos.com'],
            [
                'name' => 'Admin SmartPOS',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'petugas@smartpos.com'],
            [
                'name' => 'Petugas SmartPOS',
                'password' => bcrypt('password'),
                'role' => 'petugas',
            ]
        );

        // 2. Memanggil seeder lainnya secara berurutan
        $this->call([
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
        ]);
    }
}