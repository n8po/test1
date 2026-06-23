<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ukm;
use App\Models\AnggotaUkm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
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

        // Seed 3 UKM
        $ukmData = [
            ['nama' => 'UKM Teater Wasi Putih', 'deskripsi' => 'Unit kegiatan mahasiswa teater untuk mengembangkan bakat dan minat mahasiswa dalam bidang teater.'],
            ['nama' => 'UKM Music Generation', 'deskripsi' => 'Unit kegiatan mahasiswa musik untuk mengembangkan bakat dan minat mahasiswa dalam bidang musik.'],
            ['nama' => 'UKM Basket', 'deskripsi' => 'Unit kegiatan mahasiswa basket untuk mengembangkan bakat dan minat mahasiswa dalam olahraga basket.'],
        ];

        foreach ($ukmData as $u) {
            Ukm::create($u);
        }

        // Seed 9 mahasiswa dengan role berbeda (3 per UKM)
        $password = Hash::make('mahasiswa123');

        $mahasiswaList = [
            // UKM Teater (ukm_id=1)
            ['username' => 'ketua1', 'nama' => 'Ahmad Fauzi', 'nim' => '2210010001', 'kelas' => '2A', 'prodi' => 'Teknik Informatika', 'jurusan' => 'Teknik Elektro', 'Role' => 'ketua', 'UKM' => 'UKM Teater Wasi Putih', 'ukm_id' => 1],
            ['username' => 'sekretaris1', 'nama' => 'Rina Melati', 'nim' => '2210010011', 'kelas' => '2A', 'prodi' => 'Teknik Informatika', 'jurusan' => 'Teknik Elektro', 'Role' => 'sekretaris', 'UKM' => 'UKM Teater Wasi Putih', 'ukm_id' => 1],
            ['username' => 'anggota1', 'nama' => 'Doni Prasetyo', 'nim' => '2210010021', 'kelas' => '2A', 'prodi' => 'Teknik Informatika', 'jurusan' => 'Teknik Elektro', 'Role' => 'anggota', 'UKM' => 'UKM Teater Wasi Putih', 'ukm_id' => 1],

            // UKM Music (ukm_id=2)
            ['username' => 'ketua2', 'nama' => 'Siti Nurhaliza', 'nim' => '2210010002', 'kelas' => '1A', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro', 'Role' => 'ketua', 'UKM' => 'UKM Music Generation', 'ukm_id' => 2],
            ['username' => 'sekretaris2', 'nama' => 'Joko Susilo', 'nim' => '2210010012', 'kelas' => '1A', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro', 'Role' => 'sekretaris', 'UKM' => 'UKM Music Generation', 'ukm_id' => 2],
            ['username' => 'anggota2', 'nama' => 'Mega Sari', 'nim' => '2210010022', 'kelas' => '1A', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro', 'Role' => 'anggota', 'UKM' => 'UKM Music Generation', 'ukm_id' => 2],

            // UKM Basket (ukm_id=3)
            ['username' => 'ketua3', 'nama' => 'Budi Santoso', 'nim' => '2210010003', 'kelas' => '1B', 'prodi' => 'Manajemen', 'jurusan' => 'Ekonomi', 'Role' => 'ketua', 'UKM' => 'UKM Basket', 'ukm_id' => 3],
            ['username' => 'sekretaris3', 'nama' => 'Dewi Lestari', 'nim' => '2210010013', 'kelas' => '1B', 'prodi' => 'Manajemen', 'jurusan' => 'Ekonomi', 'Role' => 'sekretaris', 'UKM' => 'UKM Basket', 'ukm_id' => 3],
            ['username' => 'anggota3', 'nama' => 'Rudi Hermawan', 'nim' => '2210010023', 'kelas' => '2B', 'prodi' => 'Akuntansi', 'jurusan' => 'Ekonomi', 'Role' => 'anggota', 'UKM' => 'UKM Basket', 'ukm_id' => 3],
        ];

        foreach ($mahasiswaList as $mhs) {
            $ukmId = $mhs['ukm_id'];
            unset($mhs['ukm_id']);
            $mhs['password'] = $password;
            $user = User::create($mhs);
            AnggotaUkm::create([
                'user_id' => $user->id,
                'ukm_id' => $ukmId,
                'tanggal_bergabung' => now(),
            ]);
        }
    }
}
