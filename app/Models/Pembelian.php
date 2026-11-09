<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    protected $fillable = [
        'user_id',
        'kode_pembelian',
        'nama_pembeli',
        'email',
        'no_telepon',
        'alamat',
        'total_harga',
        'status',
        'catatan',
        'metode_pembayaran',
        'bukti_pembayaran'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2'
    ];

    public function detailPembelians(): HasMany
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public static function generateKodePembelian(): string
    {
        return 'TRX' . date('YmdHis') . rand(100, 999);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'       => 'Pending',
            'diproses'      => 'Diproses',
            'dapat_diambil' => 'Dapat Diambil',
            'selesai'       => 'Selesai',
            'dibatalkan'    => 'Dibatalkan',
            default         => ucfirst($this->status),
        };
    }
}
