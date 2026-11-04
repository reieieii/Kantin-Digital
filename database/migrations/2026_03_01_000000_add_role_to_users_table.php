<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom role mungkin sudah ada sebagai ENUM lama — ubah ke VARCHAR agar fleksibel
            if (Schema::hasColumn('users', 'role')) {
                \DB::statement("ALTER TABLE users MODIFY COLUMN `role` VARCHAR(20) NOT NULL DEFAULT 'user'");
                // Reset semua nilai lama yang tidak relevan ke 'user'
                \DB::table('users')
                    ->whereNotIn('role', ['user', 'admin'])
                    ->update(['role' => 'user']);
            } else {
                $table->string('role', 20)->default('user')->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
