<?php
/**
 * Module: AnggotaSeeder
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Seeder untuk data anggota UKM
 */

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ukm;
use App\Models\AnggotaUkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $anggotaList = [
            [
                'nama' => 'Budi Santoso',
                'nim' => '2021001',
                'kelas' => 'TI-1A',
                'prodi' => 'Teknik Informatika',
                'jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama' => 'Siti Rahayu',
                'nim' => '2021002',
                'kelas' => 'TI-1B',
                'prodi' => 'Teknik Informatika',
                'jurusan' => 'Teknologi Informasi',
            ],
        ];

        foreach ($anggotaList as $anggotaItem)
        {
            $user = User::create([
                'nama' => $anggotaItem['nama'],
                'nim' => $anggotaItem['nim'],
                'kelas' => $anggotaItem['kelas'],
                'prodi' => $anggotaItem['prodi'],
                'jurusan' => $anggotaItem['jurusan'],
                'password' => Hash::make('password123'),
                'Role' => 'anggota',
                'UKM' => 'Badminton',
                'email' => $anggotaItem['nim'] . '@poliban.ac.id',
            ]);

            $ukm = Ukm::first();

            AnggotaUkm::create([
                'user_id' => $user->id,
                'ukm_id' => $ukm->id,
                'tanggal_bergabung' => now(),
            ]);
        }
    }
}
