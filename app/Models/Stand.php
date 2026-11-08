<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    protected $fillable = [
        'nama_stand',
        'deskripsi',
        'gambar',
        'qris_gambar',
        'pemilik',
        'no_telepon',
        'status_buka',
        'total_pendapatan',
    ];

    protected $casts = [
        'total_pendapatan' => 'decimal:2',
        'status_buka'      => 'boolean',
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    /**
     * Tambah pendapatan dari subtotal item pesanan yang selesai.
     * Menggunakan increment agar aman dari race condition.
     */
    public function tambahPendapatan(float $jumlah): void
    {
        $this->increment('total_pendapatan', $jumlah);
    }

    /**
     * Kurangi pendapatan (dipakai saat status pesanan di-rollback dari selesai).
     */
    public function kurangiPendapatan(float $jumlah): void
    {
        $this->decrement('total_pendapatan', max(0, $jumlah));
    }
}
