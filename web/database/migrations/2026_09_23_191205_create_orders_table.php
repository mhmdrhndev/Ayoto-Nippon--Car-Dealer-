<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_spk')->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->enum('metode', ['Cash', 'Kredit', 'TradeIn']);
            $table->foreignId('leasing_id')->nullable()->constrained('leasing_partners')->nullOnDelete();
            $table->unsignedBigInteger('dp_rencana')->default(0);
            $table->unsignedSmallInteger('tenor')->nullable();
            $table->unsignedBigInteger('angsuran_estimasi')->nullable();
            $table->unsignedBigInteger('booking_fee');
            $table->enum('status', ['MenungguBayar', 'MenungguVerifikasi', 'Deal', 'Ditolak', 'Expired', 'Batal'])->default('MenungguBayar');
            $table->dateTime('deadline_at');
            $table->string('bukti_path')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('verified_at')->nullable();
            $table->text('tolak_alasan')->nullable();
            $table->timestamps();

            $table->index(['status', 'deadline_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
