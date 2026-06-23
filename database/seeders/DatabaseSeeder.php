<?php
/**
 * Module: DatabaseSeeder
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Main seeder untuk mengisi data awal sistem UKM
 * 
 * Functions:
 *   - run() : void -> jalankan semua seeder
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UkmSeeder::class,
            AdminSeeder::class,
            AnggotaSeeder::class,
            KegiatanSeeder::class,
        ]);
    }
}
