<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class JenisTagihan extends Model
{
    protected $table = 'jenis_tagihan';
    protected $fillable = [
        'Oid',
        'Jenis',
        'Jumlah'
    ];
}
