<?php
/**
 * Module: KegiatanSeeder
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Seeder untuk data kegiatan UKM
 * 
 * Functions:
 *   - run() : void -> insert data kegiatan
 */

namespace Database\Seeders;

use App\Models\Ukm;
use App\Models\Kegiatan;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $kegiatanList = [
            [
                'nama_kegiatan' => 'Teater Wasi Putih',
                'deskripsi' => 'Pertunjukan teater tahunan UKM Teater Wasi Putih.',
            ],
            [
                'nama_kegiatan' => 'Music Generation',
                'deskripsi' => 'Konser musik tahunan UKM Music Generation.',
            ],
            [
                'nama_kegiatan' => 'Basket',
                'deskripsi' => 'Turnamen basket antar kampus yang diselenggarakan oleh UKM Basket.',
            ],
            [
                'nama_kegiatan' => 'Taekwondo',
                'deskripsi' => 'Kejuaraan taekwondo tingkat regional yang diselenggarakan oleh UKM Taekwondo.',
            ],
            [
                'nama_kegiatan' => 'Shorinji Kempo',
                'deskripsi' => 'Seminar bela diri dan pertunjukan seni bela diri yang diselenggarakan oleh UKM Shorinji Kempo.',
            ],
            [
                'nama_kegiatan' => 'Pecinta Alam',
                'deskripsi' => 'Ekspedisi alam dan kegiatan konservasi lingkungan yang diselenggarakan oleh UKM Pecinta Alam.',
            ],
            [
                'nama_kegiatan' => 'Robotik',
                'deskripsi' => 'Kompetisi robotik tingkat nasional yang diselenggarakan oleh UKM Robotik.',
            ],
        ];

        $ukmList = Ukm::all();

        foreach ($kegiatanList as $index => $kegiatanItem)
        {
            $ukm = $ukmList->get($index % $ukmList->count());

            Kegiatan::create([
                'nama_kegiatan' => $kegiatanItem['nama_kegiatan'],
                'UKM' => $ukm->nama,
                'Nama' => 'Admin',
                'Kelas' => 'Staff',
                'Prodi' => 'Administrator',
                'Jurusan' => 'Sistem Informasi',
                'tanggal' => now()->addDays(rand(7, 30)),
                'deskripsi' => $kegiatanItem['deskripsi'],
            ]);
        }
    }
}
