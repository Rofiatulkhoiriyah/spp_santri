<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $fillable = [
        'Oid',
        'Santri',
        'Periode',
        'TglBayar',
        'Jumlah',
        'Jenis',
        'Status',
    ];

    public function santriObj() { return $this->belongsTo(Santri::class, 'Santri', 'Oid'); }
}
