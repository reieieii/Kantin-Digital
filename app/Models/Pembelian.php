<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    protected $fillable = [
        'kode_pembelian',
        'nama_pembeli',
        'email',
        'no_telepon',
        'alamat',
        'total_harga',
        'status',
        'catatan',
        'metode_pembayaran'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2'
    ];

    public function detailPembelians(): HasMany
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public static function generateKodePembelian(): string
    {
        return 'TRX' . date('YmdHis') . rand(100, 999);
    }
}
