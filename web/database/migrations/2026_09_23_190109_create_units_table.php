<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('vin')->unique();
            $table->foreignId('variant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('color_id')->constrained()->restrictOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['Tersedia', 'Dipesan', 'Terjual'])->default('Tersedia');
            $table->unsignedSmallInteger('tahun_rakit');
            $table->unsignedBigInteger('harga');
            $table->string('foto_utama')->nullable();
            $table->timestamps();

            $table->index(['status', 'branch_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
