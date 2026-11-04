<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    protected $fillable = [
        'nama_stand',
        'deskripsi',
        'gambar',
        'pemilik',
        'no_telepon',
        'status_buka'
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
