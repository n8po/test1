<?php
/**
 * Module: AnggotaUkm Model
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Model untuk data anggota UKM yang sudah diterima
 * 
 * Functions:
 *   - user() : belongsTo -> relasi ke User
 *   - ukm() : belongsTo -> relasi ke Ukm
 * 
 * Input Parameters:
 *   - user_id : int -> ID pengguna
 *   - ukm_id : int -> ID UKM
 *   - tanggal_bergabung : date -> tanggal menjadi anggota
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaUkm extends Model
{
    protected $fillable = [
        'user_id',
        'ukm_id',
        'jabatan',
        'tanggal_bergabung'
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ukm()
    {
        return $this->belongsTo(Ukm::class);
    }
}
