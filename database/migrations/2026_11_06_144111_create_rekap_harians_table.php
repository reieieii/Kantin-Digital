<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stand_id')->constrained('stands')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']);
            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->decimal('total_keuntungan', 15, 2)->default(0);
            $table->integer('total_pesanan')->default(0);
            $table->integer('pesanan_selesai')->default(0);
            $table->integer('pesanan_dibatalkan')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Satu stand hanya bisa punya satu rekap per tanggal
            $table->unique(['stand_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_harians');
    }
};
