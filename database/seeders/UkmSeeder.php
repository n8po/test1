<?php
/**
 * Module: UkmSeeder
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Seeder untuk data UKM
 * 
 * Functions:
 *   - run() : void -> insert data UKM
 */

namespace Database\Seeders;

use App\Models\Ukm;
use Illuminate\Database\Seeder;

class UkmSeeder extends Seeder
{
    public function run(): void
    {
        $ukmList = [
            [
                'nama' => 'UKM Teater Wasi Putih',
                'deskripsi' => 'Unit kegiatan mahasiswa teater untuk mengembangkan bakat dan minat mahasiswa dalam bidang teater.',
                'logo' => null,
            ],
            [
                'nama' => 'UKM Music Generation',
                'deskripsi' => 'Unit kegiatan mahasiswa musik untuk mengembangkan bakat dan minat mahasiswa dalam bidang musik.',
                'logo' => null,
            ],
            [
                'nama' => 'UKM Basket',
                'deskripsi' => 'Unit kegiatan mahasiswa basket untuk mengembangkan bakat dan minat mahasiswa dalam bidang olahraga basket.',
                'logo' => null,
            ],
            [
                'nama' => 'UKM Taekwondo',
                'deskripsi' => 'Unit kegiatan mahasiswa taekwondo untuk mengembangkan bakat dan minat mahasiswa dalam bidang bela diri.',
                'logo' => null,
            ],
            [
                'nama' => 'UKM Shorinji Kempo',
                'deskripsi' => 'Unit kegiatan mahasiswa seni bela diri untuk melestarikan dan mengembangkan kesenian tradisional dan modern.',
                'logo' => null,
            ],
            [
                'nama' => 'UKM Pecinta Alam',
                'deskripsi' => 'Unit kegiatan mahasiswa untuk mengembangkan minat dan bakat dalam menjaga dan melestarikan lingkungan.',
                'logo' => null,
            ],
            [
                'nama' => 'UKM Robotik',
                'deskripsi' => 'Unit kegiatan mahasiswa untuk mengembangkan kemampuan di bidang teknologi informasi dan pemrograman.',
                'logo' => null,
            ],
        ];

        foreach ($ukmList as $ukmItem)
        {
            Ukm::create($ukmItem);
        }
    }
}
