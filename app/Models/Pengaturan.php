<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $fillable = [
        'Oid',
        'Kode',
        'Isi',
        'Keterangan'
    ];
}
