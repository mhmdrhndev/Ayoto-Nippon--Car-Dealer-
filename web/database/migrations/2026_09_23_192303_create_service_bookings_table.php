<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('no_svc')->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('nopol');
            $table->string('vin')->nullable();
            $table->unsignedInteger('km');
            $table->text('keluhan');
            $table->dateTime('jadwal');
            $table->enum('status', ['Menunggu', 'Dikonfirmasi', 'Dikerjakan', 'Selesai', 'Batal'])->default('Menunggu');
            $table->unsignedBigInteger('estimasi_biaya')->default(0);
            $table->foreignId('mekanik_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['branch_id', 'jadwal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_bookings');
    }
};
