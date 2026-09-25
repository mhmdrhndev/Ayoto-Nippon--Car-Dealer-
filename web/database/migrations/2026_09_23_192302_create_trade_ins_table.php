<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('merk_tipe');
            $table->unsignedSmallInteger('tahun');
            $table->unsignedInteger('km');
            $table->json('foto_paths')->nullable();
            $table->enum('status', ['Diajukan', 'Inspeksi', 'Ditawar', 'Deal', 'Ditolak'])->default('Diajukan');
            $table->unsignedBigInteger('harga_penawaran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_ins');
    }
};
