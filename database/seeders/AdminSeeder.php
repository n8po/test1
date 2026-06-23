<?php
/**
 * Module: AdminSeeder
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Seeder untuk data administrator
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminList = [
            [
                'nama' => 'Administrator',
                'nim' => 'ADMIN001',
                'kelas' => 'Staff',
                'prodi' => 'Administrator',
                'jurusan' => 'Poliban',
                'Role' => 'administrator',
                'UKM' => 'Administrator',
                'password' => Hash::make('admin123'),
            ],
        ];

        foreach ($adminList as $adminItem)
        {
            User::create(array_merge($adminItem, [
                'email' => strtolower($adminItem['nim']) . '@poliban.ac.id'
            ]));
        }
    }
}
