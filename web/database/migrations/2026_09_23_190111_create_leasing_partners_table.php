<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leasing_partners', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telp')->nullable();
            $table->unsignedTinyInteger('dp_min_persen')->default(20);
            $table->string('tenor_list')->default('12,24,36,48');
            $table->decimal('bunga_dasar', 5, 2)->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leasing_partners');
    }
};
