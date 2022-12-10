<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengguna extends Authenticatable
{
    use HasFactory; use SoftDeletes;

    protected $primaryKey = 'Oid';
    protected $keyType = 'char';
    public $incrementing = false;
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    const DELETED_AT = 'DeletedAt';

    protected $table = 'pengguna';
    protected $fillable = [
        'Oid',
        'Nama',
        'Username',
        'Password'
    ];

    protected $hidden = [
        'Password',
    ];
}
