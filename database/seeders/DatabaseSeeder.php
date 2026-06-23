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

use App\Models\User;
use App\Models\Ukm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed admin user
        User::create([
            'username' => 'admin',
            'nama' => 'Administrator',
            'nim' => 'ADMIN001',
            'kelas' => 'Staff',
            'prodi' => 'Administrator',
            'jurusan' => 'Poliban',
            'Role' => 'administrator',
            'UKM' => 'Administrator',
            'password' => Hash::make('admin123'),
        ]);

        // Seed 5 sample mahasiswa
        $mahasiswaList = [
            [
                'username' => 'mahasiswa1',
                'nama' => 'Ahmad Fauzi',
                'nim' => '2210010001',
                'kelas' => '1A',
                'prodi' => 'Teknik Informatika',
                'jurusan' => 'Teknik Elektro',
                'Role' => 'anggota',
                'UKM' => 'UKM Teater Wasi Putih',
                'password' => Hash::make('mahasiswa123'),
            ],
            [
                'username' => 'mahasiswa2',
                'nama' => 'Siti Nurhaliza',
                'nim' => '2210010002',
                'kelas' => '1A',
                'prodi' => 'Teknik Informatika',
                'jurusan' => 'Teknik Elektro',
                'Role' => 'anggota',
                'UKM' => 'UKM Music Generation',
                'password' => Hash::make('mahasiswa123'),
            ],
            [
                'username' => 'mahasiswa3',
                'nama' => 'Budi Santoso',
                'nim' => '2210010003',
                'kelas' => '1B',
                'prodi' => 'Sistem Informasi',
                'jurusan' => 'Teknik Elektro',
                'Role' => 'anggota',
                'UKM' => 'UKM Basket',
                'password' => Hash::make('mahasiswa123'),
            ],
            [
                'username' => 'mahasiswa4',
                'nama' => 'Dewi Lestari',
                'nim' => '2210010004',
                'kelas' => '1B',
                'prodi' => 'Sistem Informasi',
                'jurusan' => 'Teknik Elektro',
                'Role' => 'anggota',
                'UKM' => 'UKM Robotik',
                'password' => Hash::make('mahasiswa123'),
            ],
            [
                'username' => 'mahasiswa5',
                'nama' => 'Rudi Hermawan',
                'nim' => '2210010005',
                'kelas' => '1A',
                'prodi' => 'Teknik Informatika',
                'jurusan' => 'Teknik Elektro',
                'Role' => 'anggota',
                'UKM' => 'UKM Pecinta Alam',
                'password' => Hash::make('mahasiswa123'),
            ],
        ];

        foreach ($mahasiswaList as $mhs) {
            User::create($mhs);
        }

        // Seed 3 sample UKM
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
        ];

        foreach ($ukmList as $ukmItem) {
            Ukm::create($ukmItem);
        }
    }
}
