<?php
/**
 * Script untuk membersihkan data stand duplikat di Railway.
 * Jalankan: php fix_duplicate_stands.php
 * Hapus file ini setelah dijalankan.
 */
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Stand;

// Ambil semua nama stand yang duplikat
$duplikat = DB::table('stands')
    ->select('nama_stand', DB::raw('COUNT(*) as total'), DB::raw('MIN(id) as keep_id'))
    ->groupBy('nama_stand')
    ->having(DB::raw('COUNT(*)'), '>', 1)
    ->get();

if ($duplikat->isEmpty()) {
    echo "Tidak ada duplikat. Data sudah bersih.\n";
    exit;
}

$hapusCount = 0;

foreach ($duplikat as $d) {
    // Hapus semua kecuali ID terkecil (yang paling lama)
    $hapus = DB::table('stands')
        ->where('nama_stand', $d->nama_stand)
        ->where('id', '!=', $d->keep_id)
        ->get();

    foreach ($hapus as $stand) {
        // Hapus produk milik stand duplikat dulu
        $produkIds = DB::table('produks')->where('stand_id', $stand->id)->pluck('id');
        DB::table('detail_pembelians')->whereIn('produk_id', $produkIds)->delete();
        DB::table('produks')->where('stand_id', $stand->id)->delete();
        DB::table('rekap_harians')->where('stand_id', $stand->id)->delete();
        // Update user yang punya stand_id duplikat ke stand yang dipertahankan
        DB::table('users')->where('stand_id', $stand->id)->update(['stand_id' => $d->keep_id]);
        // Hapus stand duplikat
        DB::table('stands')->where('id', $stand->id)->delete();
        $hapusCount++;
    }

    echo "Stand '{$d->nama_stand}': pertahankan ID={$d->keep_id}, hapus " . count($hapus) . " duplikat.\n";
}

echo "\nSelesai! Total {$hapusCount} stand duplikat dihapus.\n";
echo "Jumlah stand sekarang: " . DB::table('stands')->count() . "\n";
