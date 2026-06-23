<?php
/**
 * Module: Pendaftaran Model
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Model untuk data pendaftaran anggota UKM
 * 
 * Functions:
 *   - user() : belongsTo -> relasi ke User
 *   - ukm() : belongsTo -> relasi ke Ukm
 * 
 * Input Parameters:
 *   - user_id : int -> ID pengguna
 *   - ukm_id : int -> ID UKM
 *   - alasan : string -> alasan mendaftar
 *   - status : enum -> pending/diterima/ditolak
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'user_id',
        'ukm_id',
        'alasan',
        'status'
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
