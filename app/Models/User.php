<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'nama',
        'nim',
        'kelas',
        'prodi',
        'jurusan',
        'Role',
        'status',
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

    public function anggotaAktif()
    {
        return $this->hasOne(AnggotaUkm::class);
    }

    public function isAdmin(): bool
    {
        return $this->Role === 'administrator';
    }

    public function isKetua(): bool
    {
        return $this->Role === 'ketua';
    }

    public function isSekretaris(): bool
    {
        return $this->Role === 'sekretaris';
    }

    public function isPengurus(): bool
    {
        return $this->isKetua() || $this->isSekretaris();
    }

    public function getUkmId(): ?int
    {
        return $this->anggotaAktif?->ukm_id;
    }
}
