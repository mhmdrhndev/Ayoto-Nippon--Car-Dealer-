<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('otr');
            $table->unsignedBigInteger('bbn')->default(0);
            $table->unsignedBigInteger('diskon')->default(0);
            $table->date('berlaku_dari')->nullable();
            $table->date('berlaku_sampai')->nullable();
            $table->timestamps();

            $table->unique(['variant_id', 'branch_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_lists');
    }
};
