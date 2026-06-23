<?php
/**
 * Module: User Model
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Model untuk data pengguna (mahasiswa dan administrator)
 * 
 * Functions:
 *   - anggotaUkm() : hasMany -> relasi ke AnggotaUkm
 *   - pendaftaran() : hasMany -> relasi ke Pendaftaran
 *   - isAdmin() : bool -> cek role administrator
 * 
 * Global Variables Accessed:
 *   - $fillable (array) - field yang dapat diisi
 *   - $hidden (array) - field yang disembunyikan
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'nim',
        'kelas',
        'prodi',
        'jurusan',
        'Role',
        'UKM',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function anggotaUkm()
    {
        return $this->hasMany(AnggotaUkm::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function isAdmin(): bool
    {
        return $this->Role === 'administrator';
    }
}
