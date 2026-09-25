<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_model_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->enum('transmisi', ['MT', 'AT', 'CVT']);
            $table->string('bbm');
            $table->json('spesifikasi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
