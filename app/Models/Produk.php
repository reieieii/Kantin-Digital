<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'stand_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stock',
        'gambar',
        'kategori',
        'tersedia'
    ];

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }

    public function favorits()
    {
        return $this->hasMany(Favorit::class);
    }
}
