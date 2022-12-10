<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class Santri extends Model
{
    protected $table = 'santri';
    protected $fillable = [
        'Oid',
        'Pengguna',
        'Aktif',
        'Foto',
        'Nama',
        'NIK',
        'NIS',
        'TglLahir',
        'JenisKelamin',
        'Agama',
        'Hobi',
        'CitaCita',
        'NoHp',
        'TglMasuk',
    ];

    public function penggunaObj() { return $this->belongsTo(Pengguna::class, 'Pengguna', 'Oid'); }
    public function hafalanObj() { return $this->hasMany(Hafalan::class, 'Santri', 'Oid'); }
    public function tagihanObj() { return $this->hasMany(Tagihan::class, 'Santri', 'Oid'); }
}
