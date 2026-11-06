<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekapHarian extends Model
{
    protected $table = 'rekap_harians';

    protected $fillable = [
        'stand_id',
        'tanggal',
        'hari',
        'total_pendapatan',
        'total_keuntungan',
        'total_pesanan',
        'pesanan_selesai',
        'pesanan_dibatalkan',
        'catatan',
    ];

    protected $casts = [
        'tanggal'           => 'date',
        'total_pendapatan'  => 'decimal:2',
        'total_keuntungan'  => 'decimal:2',
    ];

    public function stand(): BelongsTo
    {
        return $this->belongsTo(Stand::class);
    }

    /** Nama hari Indonesia dari tanggal Carbon */
    public static function namaHariDari(\Carbon\Carbon $tanggal): string
    {
        $map = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
        return $map[$tanggal->dayOfWeek];
    }
}
