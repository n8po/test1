<?php
/**
 * Module: Ukm Model
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Model untuk data Unit Kegiatan Mahasiswa
 * 
 * Functions:
 *   - anggota() : hasMany -> relasi ke AnggotaUkm
 *   - pendaftaran() : hasMany -> relasi ke Pendaftaran
 *   - kegiatans() : hasMany -> relasi ke Kegiatan
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ukm extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'logo'
    ];

    public function anggota()
    {
        return $this->hasMany(AnggotaUkm::class);
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'UKM', 'nama');
    }
}
