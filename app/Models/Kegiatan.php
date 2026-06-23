<?php
/**
 * Module: Kegiatan Model
 * Created: 2026-06-23
 * Author: System
 * Synopsis: Model untuk data kegiatan UKM
 * 
 * Functions:
 *   - ukm() : belongsTo -> relasi ke Ukm
 * 
 * Input Parameters:
 *   - nama_kegiatan : string -> nama kegiatan
 *   - UKM : string -> nama UKM penyelenggara
 *   - tanggal : date -> tanggal pelaksanaan
 *   - deskripsi : text -> deskripsi kegiatan
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'UKM',
        'tanggal',
        'deskripsi'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function ukm()
    {
        return $this->belongsTo(Ukm::class, 'UKM', 'nama');
    }
}
