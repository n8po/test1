<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ukm;
use App\Models\AnggotaUkm;
use App\Models\Pendaftaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'Wakil Direktur III',
            'email' => 'wadir3@poliban.ac.id',
            'nama' => 'Wakil Direktur III',
            'nim' => 'ADMIN001',
            'kelas' => 'Staff',
            'prodi' => 'Administrator',
            'jurusan' => 'Poliban',
            'Role' => 'administrator',
            'UKM' => 'Administrator',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'username' => 'Kepala Bagian Akademik',
            'email' => 'kabagakademik@poliban.ac.id',
            'nama' => 'Kepala Bagian Akademik',
            'nim' => 'ADMIN002',
            'kelas' => 'Staff',
            'prodi' => 'Administrator',
            'jurusan' => 'Poliban',
            'Role' => 'administrator',
            'UKM' => 'Administrator',
            'password' => Hash::make('admin123'),
        ]);

        // Seed UKMs (exceeding 6 for pagination verification)
        $ukmData = [
            ['nama' => 'UKM Wasi Putih', 'deskripsi' => 'Unit kegiatan mahasiswa teater untuk mengembangkan bakat dan minat mahasiswa dalam bidang teater.'],
            ['nama' => 'UKM Music Generation', 'deskripsi' => 'Unit kegiatan mahasiswa musik untuk mengembangkan bakat dan minat mahasiswa dalam bidang musik.'],
            ['nama' => 'UKM Basket', 'deskripsi' => 'Unit kegiatan mahasiswa basket untuk mengembangkan bakat dan minat mahasiswa dalam olahraga basket.'],
            ['nama' => 'UKM Taekwondo', 'deskripsi' => 'Unit kegiatan mahasiswa taekwondo untuk mengembangkan bakat dan minat mahasiswa dalam bidang bela diri.'],
            ['nama' => 'UKM Shorinji Kempo', 'deskripsi' => 'Unit kegiatan mahasiswa seni bela diri untuk melestarikan dan mengembangkan kesenian tradisional dan modern.'],
            ['nama' => 'UKM Pecinta Alam', 'deskripsi' => 'Unit kegiatan mahasiswa untuk mengembangkan minat dan bakat dalam menjaga dan melestarikan lingkungan.'],
            ['nama' => 'UKM Robotik', 'deskripsi' => 'Unit kegiatan mahasiswa untuk mengembangkan kemampuan di bidang teknologi informasi dan pemrograman.'],
        ];

        foreach ($ukmData as $u) {
            Ukm::create($u);
        }

        // Seed mahasiswa dengan role berbeda (termasuk yang pending permohonannya)
        $password = Hash::make('mahasiswa123');

        $mahasiswaList = [
            // UKM Wasi Putih (ukm_id=1)
            ['username' => 'ketua1', 'nama' => 'Ahmad Fauzi', 'nim' => '2210010001', 'kelas' => '2A', 'prodi' => 'Teknik Informatika', 'jurusan' => 'Teknik Elektro', 'Role' => 'ketua', 'status' => 'approved', 'UKM' => 'UKM Wasi Putih', 'ukm_id' => 1, 'jabatan' => 'ketua'],
            ['username' => 'sekretaris1', 'nama' => 'Rina Melati', 'nim' => '2210010011', 'kelas' => '2A', 'prodi' => 'Teknik Informatika', 'jurusan' => 'Teknik Elektro', 'Role' => 'sekretaris', 'status' => 'approved', 'UKM' => 'UKM Wasi Putih', 'ukm_id' => 1, 'jabatan' => 'sekretaris'],
            ['username' => 'anggota1', 'nama' => 'Doni Prasetyo', 'nim' => '2210010021', 'kelas' => '2A', 'prodi' => 'Teknik Informatika', 'jurusan' => 'Teknik Elektro', 'Role' => 'anggota', 'status' => 'approved', 'UKM' => 'UKM Wasi Putih', 'ukm_id' => 1, 'jabatan' => 'anggota'],

            // UKM Music (ukm_id=2)
            ['username' => 'ketua2', 'nama' => 'Siti Nurhaliza', 'nim' => '2210010002', 'kelas' => '1A', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro', 'Role' => 'ketua', 'status' => 'approved', 'UKM' => 'UKM Music Generation', 'ukm_id' => 2, 'jabatan' => 'ketua'],
            ['username' => 'sekretaris2', 'nama' => 'Joko Susilo', 'nim' => '2210010012', 'kelas' => '1A', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro', 'Role' => 'sekretaris', 'status' => 'approved', 'UKM' => 'UKM Music Generation', 'ukm_id' => 2, 'jabatan' => 'sekretaris'],
            ['username' => 'anggota2', 'nama' => 'Mega Sari', 'nim' => '2210010022', 'kelas' => '1A', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro', 'Role' => 'anggota', 'status' => 'approved', 'UKM' => 'UKM Music Generation', 'ukm_id' => 2, 'jabatan' => 'anggota'],

            // UKM Basket (ukm_id=3)
            ['username' => 'ketua3', 'nama' => 'Budi Santoso', 'nim' => '2210010003', 'kelas' => '1B', 'prodi' => 'Manajemen', 'jurusan' => 'Ekonomi', 'Role' => 'ketua', 'status' => 'approved', 'UKM' => 'UKM Basket', 'ukm_id' => 3, 'jabatan' => 'ketua'],
            ['username' => 'sekretaris3', 'nama' => 'Dewi Lestari', 'nim' => '2210010013', 'kelas' => '1B', 'prodi' => 'Manajemen', 'jurusan' => 'Ekonomi', 'Role' => 'sekretaris', 'status' => 'approved', 'UKM' => 'UKM Basket', 'ukm_id' => 3, 'jabatan' => 'sekretaris'],
            ['username' => 'anggota3', 'nama' => 'Rudi Hermawan', 'nim' => '2210010023', 'kelas' => '2B', 'prodi' => 'Akuntansi', 'jurusan' => 'Ekonomi', 'Role' => 'anggota', 'status' => 'approved', 'UKM' => 'UKM Basket', 'ukm_id' => 3, 'jabatan' => 'anggota'],

            // Pending registrations (permohonan)
            ['username' => 'pending1', 'nama' => 'Bambang Tri', 'nim' => '2210010031', 'kelas' => '2C', 'prodi' => 'Teknik Informatika', 'jurusan' => 'Teknik Elektro', 'Role' => 'anggota', 'status' => 'pending', 'UKM' => 'Belum Memilih', 'ukm_id' => 1, 'is_pending' => true],
            ['username' => 'pending2', 'nama' => 'Lutfi Hakim', 'nim' => '2210010032', 'kelas' => '1C', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro', 'Role' => 'anggota', 'status' => 'pending', 'UKM' => 'Belum Memilih', 'ukm_id' => 2, 'is_pending' => true],
        ];

        foreach ($mahasiswaList as $mhs) {
            $ukmId = $mhs['ukm_id'];
            $isPending = $mhs['is_pending'] ?? false;
            $jabatan = $mhs['jabatan'] ?? 'anggota';
            unset($mhs['ukm_id'], $mhs['is_pending'], $mhs['jabatan']);
            
            $mhs['email'] = $mhs['username'] . '@poliban.ac.id';
            $mhs['password'] = $password;
            $user = User::create($mhs);

            if ($isPending) {
                Pendaftaran::create([
                    'user_id' => $user->id,
                    'ukm_id' => $ukmId,
                    'alasan' => 'Diajukan oleh pengurus UKM',
                    'status' => 'pending',
                ]);
            } else {
                AnggotaUkm::create([
                    'user_id' => $user->id,
                    'ukm_id' => $ukmId,
                    'jabatan' => $jabatan,
                    'tanggal_bergabung' => now(),
                ]);
            }
        }

        // Mahasiswa tanpa UKM (untuk testing "Tambah Anggota")
        $freeMahasiswa = [
            ['username' => 'mhs_free1', 'nama' => 'Andi Wijaya', 'nim' => '2210010041', 'kelas' => '3A', 'prodi' => 'Teknik Informatika', 'jurusan' => 'Teknik Elektro', 'Role' => 'anggota', 'status' => 'approved', 'UKM' => 'Belum Memilih'],
            ['username' => 'mhs_free2', 'nama' => 'Putri Ayu', 'nim' => '2210010042', 'kelas' => '3B', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro', 'Role' => 'anggota', 'status' => 'approved', 'UKM' => 'Belum Memilih'],
            ['username' => 'mhs_free3', 'nama' => 'Rizky Firmansyah', 'nim' => '2210010043', 'kelas' => '2C', 'prodi' => 'Manajemen', 'jurusan' => 'Ekonomi', 'Role' => 'anggota', 'status' => 'approved', 'UKM' => 'Belum Memilih'],
            ['username' => 'mhs_free4', 'nama' => 'Sari Indah', 'nim' => '2210010044', 'kelas' => '1A', 'prodi' => 'Akuntansi', 'jurusan' => 'Ekonomi', 'Role' => 'anggota', 'status' => 'approved', 'UKM' => 'Belum Memilih'],
        ];

        foreach ($freeMahasiswa as $fm) {
            $fm['email'] = $fm['username'] . '@poliban.ac.id';
            $fm['password'] = $password;
            User::create($fm);
        }

        for ($i = 5; $i <= 35; $i++) {
            User::create([
                'username' => "mhs_free_extra{$i}",
                'email' => "mhs_free_extra{$i}@poliban.ac.id",
                'nama' => "Mahasiswa Extra {$i}",
                'nim' => "2210010" . sprintf("%03d", 40 + $i),
                'kelas' => "2A",
                'prodi' => 'Teknik Informatika',
                'jurusan' => 'Teknik Elektro',
                'Role' => 'anggota',
                'status' => 'approved',
                'UKM' => 'Belum Memilih',
                'password' => $password,
            ]);
        }
    }
}
