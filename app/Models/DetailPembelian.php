<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPembelian extends Model
{
    protected $fillable = [
        'pembelian_id',
        'produk_id',
        'nama_produk',
        'quantity',
        'harga',
        'subtotal'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
