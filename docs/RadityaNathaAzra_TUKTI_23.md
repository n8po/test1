# DOKUMENTASI SISTEM UKM POLIBAN
## TUGAS UJIAN KOMPETENSI TEKNOLOGI INFORMASI (TUKTI)
**Nama: Raditya Natha Azra**
**Tanggal: 23 Juni 2026**

---

## BAB I. PENDAHULUAN

### 1.1 Latar Belakang
Sistem UKM Poliban adalah aplikasi web untuk mengelola Unit Kegiatan Mahasiswa di Politeknik Negeri Banjarmasin. Sistem ini memungkinkan administrator untuk mengelola data mahasiswa, UKM, pendaftaran anggota, dan anggota UKM secara terintegrasi.

### 1.2 Tujuan
1. Mengelola data mahasiswa secara digital
2. Mengelola data UKM dengan efisien
3. Mempermudah proses pendaftaran anggota UKM
4. Menyediakan fitur pencarian, export excel, dan cetak data

---

## BAB II. SPESIFIKASI KEBUTUHAN

### 2.1 Kebutuhan Fungsional

| ID | Fitur | Deskripsi |
|----|-------|-----------|
| FR-001 | Autentikasi | Login/logout administrator |
| FR-002 | Manajemen Mahasiswa | CRUD data mahasiswa |
| FR-003 | Manajemen UKM | CRUD data UKM |
| FR-004 | Pendaftaran | Pendaftaran anggota dengan status pending |
| FR-005 | Persetujuan | Setujui/tolak pendaftaran |
| FR-006 | Anggota UKM | CRUD anggota yang diterima |
| FR-007 | Pencarian | Fitur pencarian data |
| FR-008 | Export Excel | Export data ke CSV |
| FR-009 | Cetak | Fitur cetak data |

### 2.2 Kebutuhan Non-Fungsional

| ID | Kriteria | Target |
|----|----------|--------|
| NFR-001 | Performance | Response time < 3 detik |
| NFR-002 | Security | Password ter-hash (bcrypt) |
| NFR-003 | Availability | 99% uptime |
| NFR-004 | Usability | Interface modern dengan BlatUI |

---

## BAB III. ARSITEKTUR SISTEM

### 3.1 Teknologi yang Digunakan
- **Backend**: Laravel 13.x (PHP 8.4)
- **Frontend**: Blade Template + Tailwind CSS
- **UI Components**: BlatUI (shadcn/ui for Laravel)
- **Database**: MySQL
- **Testing**: Playwright (screenshot automation)

### 3.2 Struktur Folder
```
C:\Project\latihan\ukm_poliban\
├── app\
│   ├── Http\Controllers\      # Controller (SOP Coding)
│   ├── Models\                # Eloquent Models
│   └── View\Components\       # Custom Components
├── database\
│   ├── migrations\            # Schema Database
│   └── seeders\               # Data Awal
├── resources\views\           # Blade Templates
├── routes\web.php             # Routing
└── screenshots\               # Dokumentasi Visual
```

---

## BAB IV. IMPLEMENTASI

### 4.1 Database Schema

**Tabel Users (Mahasiswa)**
- id, nama, nim, kelas, prodi, jurusan, Role, UKM, password

**Tabel UKM**
- id, nama, deskripsi, logo

**Tabel Pendaftaran**
- id, user_id, ukm_id, alasan, status

**Tabel Anggota UKM**
- id, user_id, ukm_id, tanggal_bergabung

### 4.2 Akun Sistem

| Role | NIM | Password |
|------|-----|----------|
| Administrator | ADMIN001 | admin123 |

### 4.3 Data UKM yang Tersedia
1. Badminton
2. Basket
3. Futsal
4. Pramuka
5. Seni Tari
6. Paduan Suara
7. English Club
8. IT Club

---

## BAB V. BLACKBOX TESTING

### 5.1 Test Cases

| TC-ID | Skenario | Input | Expected Output | Status |
|-------|----------|-------|-----------------|--------|
| TC-001 | Login berhasil | ADMIN001/admin123 | Dashboard | PASS |
| TC-002 | Login gagal | SALAH/salah | Error message | PASS |
| TC-003 | Tambah mahasiswa | Data lengkap | Data tersimpan | PASS |
| TC-004 | Edit mahasiswa | Data baru | Data terupdate | PASS |
| TC-005 | Hapus mahasiswa | ID valid | Data terhapus | PASS |
| TC-006 | Tambah UKM | Nama, deskripsi | UKM tersimpan | PASS |
| TC-007 | Setujui pendaftaran | ID valid | Status diterima | PASS |
| TC-008 | Export Excel | Request | File CSV | PASS |
| TC-009 | Cetak data | Request | Print preview | PASS |

### 5.2 Hasil Testing
- Total Test: 9
- Passed: 9
- Failed: 0
- Success Rate: 100%

---

## BAB VI. PANDUAN PENGGUNAAN

### 6.1 Login
1. Buka browser, akses `http://localhost:8000`
2. Masukkan NIM: `ADMIN001`
3. Masukkan Password: `admin123`
4. Klik tombol "Login"

### 6.2 Mengelola Mahasiswa
1. Dari dashboard, klik menu "Mahasiswa"
2. Untuk menambah: Klik "Tambah", isi form, simpan
3. Untuk mengedit: Klik "Edit", ubah data, simpan
4. Untuk menghapus: Klik "Hapus", konfirmasi

### 6.3 Mengelola UKM
1. Klik menu "Unit Kegiatan"
2. CRUD sama seperti mahasiswa

### 6.4 Persetujuan Pendaftaran
1. Klik menu "Pendaftaran"
2. Lihat daftar pendaftaran pending
3. Klik "Setujui" atau "Tolak"

---

## BAB VII. KESIMPULAN

Sistem UKM Poliban telah berhasil dibangun dengan fitur:
1. ✅ Manajemen mahasiswa lengkap (CRUD, cari, export, cetak)
2. ✅ Manajemen UKM lengkap
3. ✅ Sistem pendaftaran anggota dengan validasi 1 UKM per mahasiswa
4. ✅ Dashboard statistik yang informatif
5. ✅ UI modern menggunakan BlatUI components
6. ✅ Kode mengikuti SOP coding standard
7. ✅ Testing menggunakan Playwright untuk dokumentasi visual

---

**Dokumentasi ini dibuat untuk memenuhi TUGAS UJIAN KOMPETENSI TEKNOLOGI INFORMASI (TUKTI)**
**Politeknik Negeri Banjarmasin - 2026**
