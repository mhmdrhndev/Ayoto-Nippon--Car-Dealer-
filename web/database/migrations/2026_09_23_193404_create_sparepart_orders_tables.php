<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sparepart_orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_spo')->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('total')->default(0);
            $table->enum('status', ['MenungguBayar', 'Lunas', 'Batal'])->default('MenungguBayar');
            $table->dateTime('deadline_at');
            $table->string('bukti_path')->nullable();
            $table->timestamps();
        });

        Schema::create('sparepart_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sparepart_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sparepart_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('qty');
            $table->unsignedBigInteger('harga_satuan');
            $table->unsignedBigInteger('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sparepart_order_items');
        Schema::dropIfExists('sparepart_orders');
    }
};
