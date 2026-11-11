<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dateTime('jadwal_serah_at')->nullable()->after('bast_path');
            $table->dateTime('bast_at')->nullable()->after('jadwal_serah_at');
            $table->dateTime('stnk_selesai_at')->nullable()->after('bast_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['jadwal_serah_at', 'bast_at', 'stnk_selesai_at']);
        });
    }
};
