<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class DasborPengumuman extends Model
{
    protected $table = 'dasbor_pengumuman';
    protected $fillable = [
        'Oid',
        'Judul',
        'Deskripsi',
        'Tampilkan'
    ];
}
