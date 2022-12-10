<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class Wali extends Model
{
    protected $table = 'wali';
    protected $fillable = [
        'Oid',
        'Pengguna',
        'Santri'
    ];

    public function penggunaObj() { return $this->belongsTo(Pengguna::class, 'Pengguna', 'Oid'); }
    public function santriObj() { return $this->belongsTo(Santri::class, 'Santri', 'Oid'); }
}
