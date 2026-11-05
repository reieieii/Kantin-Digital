<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Stand;

class PenjagaSeeder extends Seeder
{
    public function run(): void
    {
        // Data penjaga sesuai urutan stand di StandSeeder
        $penjaga = [
            ['nama' => 'Pak Haji',  'email' => 'rekayasaperangkatlunak@kantin.id', 'stand_nama' => 'Stand Rekayasa Perangkat Lunak'],
            ['nama' => 'Bu Siti',   'email' => 'bisnisdigital@kantin.id',           'stand_nama' => 'Stand Bisnis Digital'],
            ['nama' => 'Pak Budi',  'email' => 'managementperkantoran1@kantin.id',  'stand_nama' => 'Stand Management Perkantoran 1'],
            ['nama' => 'Pak Ahmad', 'email' => 'managementperkantoran2@kantin.id',  'stand_nama' => 'Stand Management Perkantoran 2'],
            ['nama' => 'Pak Rudi',  'email' => 'akuntansi1@kantin.id',              'stand_nama' => 'Stand Akuntansi 1'],
            ['nama' => 'Bu Nur',    'email' => 'akuntansi2@kantin.id',              'stand_nama' => 'Stand Akuntansi 2'],
            ['nama' => 'Bu Ani',    'email' => 'layananperbankan@kantin.id',        'stand_nama' => 'Stand Layanan Perbankan Syariah'],
            ['nama' => 'Pak Doni',  'email' => 'bisnisretail@kantin.id',            'stand_nama' => 'Stand Bisnis Retail'],
        ];

        foreach ($penjaga as $data) {
            $stand = Stand::where('nama_stand', $data['stand_nama'])->first();

            if (!$stand) {
                $this->command->warn("Stand '{$data['stand_nama']}' tidak ditemukan, skip.");
                continue;
            }

            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['nama'],
                    'password' => Hash::make('penjaga123'),
                    'role'     => 'penjaga',
                    'stand_id' => $stand->id,
                ]
            );

            $this->command->info("Akun penjaga '{$data['nama']}' → {$data['email']} berhasil dibuat.");
        }
    }
}
