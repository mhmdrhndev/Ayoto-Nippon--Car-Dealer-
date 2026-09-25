<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_booking_id')->constrained()->cascadeOnDelete();
            $table->enum('jenis', ['Pekerjaan', 'Sparepart']);
            $table->string('deskripsi');
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedBigInteger('harga_satuan')->default(0);
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->foreignId('sparepart_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};
