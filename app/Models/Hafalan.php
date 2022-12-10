<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class Hafalan extends Model
{
    protected $table = 'hafalan';
    protected $fillable = [
        'Oid',
        'Santri',
        'Surah',
        'Tanggal',
        'Keterangan'
    ];

    public function santriObj() { return $this->belongsTo(Santri::class, 'Santri', 'Oid'); }
}
