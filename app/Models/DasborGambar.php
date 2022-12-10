<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class DasborGambar extends Model
{
    protected $table = 'dasbor_gambar';
    protected $fillable = [
        'Oid',
        'Direktori',
        'Judul',
        'Deskripsi',
        'Tampilkan'
    ];
}
