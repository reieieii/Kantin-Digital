<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stand;

class StandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gunakan updateOrCreate agar tidak duplikat saat seeder dijalankan ulang
        $stands = [
            [
                'nama_stand' => 'Stand Rekayasa Perangkat Lunak',
                'deskripsi' => 'Nasi Padang dengan berbagai lauk khas Minang',
                'gambar' => 'https://via.placeholder.com/400x300/DC2626/FFFFFF?text=Stand+Nasi+Padang',
                'pemilik' => 'Pak Haji',
                'no_telepon' => '0812-1111-2222',
                'status_buka' => true,
            ],
            [
                'nama_stand' => 'Stand Bisnis Digital',
                'deskripsi' => 'Ayam bakar dengan sambal dan lalapan',
                'gambar' => 'https://via.placeholder.com/400x300/EA580C/FFFFFF?text=Stand+Ayam+Bakar',
                'pemilik' => 'Bu Siti',
                'no_telepon' => '0813-3333-4444',
                'status_buka' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_stand' => 'Stand Management Perkantoran 1',
                'deskripsi' => 'Mie ayam dengan pangsit dan bakso',
                'gambar' => 'https://via.placeholder.com/400x300/F59E0B/FFFFFF?text=Stand+Mie+Ayam',
                'pemilik' => 'Pak Budi',
                'no_telepon' => '0814-5555-6666',
                'status_buka' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_stand' => 'Stand Management Perkantoran 2',
                'deskripsi' => 'Soto ayam dengan telur dan kerupuk',
                'gambar' => 'https://via.placeholder.com/400x300/10B981/FFFFFF?text=Stand+Soto',
                'pemilik' => 'Pak Ahmad',
                'no_telepon' => '0815-7777-8888',
                'status_buka' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_stand' => 'Stand Akuntansi 1',
                'deskripsi' => 'Bakso urat dengan mie dan sayuran',
                'gambar' => 'https://via.placeholder.com/400x300/8B5CF6/FFFFFF?text=Stand+Bakso',
                'pemilik' => 'Pak Rudi',
                'no_telepon' => '0816-9999-0000',
                'status_buka' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_stand' => 'Stand Akuntansi 2',
                'deskripsi' => 'Gado-gado dengan lontong dan kerupuk',
                'gambar' => 'https://via.placeholder.com/400x300/059669/FFFFFF?text=Stand+Gado-Gado',
                'pemilik' => 'Bu Nur',
                'no_telepon' => '0817-1234-5678',
                'status_buka' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_stand' => 'Stand Layanan Perbankan Syariah',
                'deskripsi' => 'Es buah segar dengan susu dan jelly',
                'gambar' => 'https://via.placeholder.com/400x300/0891B2/FFFFFF?text=Stand+Es+Buah',
                'pemilik' => 'Bu Ani',
                'no_telepon' => '0818-8765-4321',
                'status_buka' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_stand' => 'Stand Bisnis Retail',
                'deskripsi' => 'Berbagai jus segar dan kopi susu',
                'gambar' => 'https://via.placeholder.com/400x300/BE185D/FFFFFF?text=Stand+Jus+&+Kopi',
                'pemilik' => 'Pak Doni',
                'no_telepon' => '0819-2468-1357',
                'status_buka' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Stand::insert($stands);
    }
}
