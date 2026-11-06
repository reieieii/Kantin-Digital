<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stands', function (Blueprint $table) {
            $table->decimal('total_pendapatan', 15, 2)->default(0)->after('status_buka')
                  ->comment('Akumulasi pendapatan dari pesanan yang berstatus selesai');
        });
    }

    public function down(): void
    {
        Schema::table('stands', function (Blueprint $table) {
            $table->dropColumn('total_pendapatan');
        });
    }
};
