<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stands', function (Blueprint $table) {
            $table->string('qris_gambar')->nullable()->after('gambar')
                  ->comment('Path foto QRIS milik penjaga stand (per-stand, nullable)');
        });
    }

    public function down(): void
    {
        Schema::table('stands', function (Blueprint $table) {
            $table->dropColumn('qris_gambar');
        });
    }
};
