<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sales_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('sumber', ['Web', 'WA', 'Showroom'])->default('Web');
            $table->enum('status', ['Baru', 'Dihubungi', 'TestDrive', 'SPK', 'Deal', 'Batal'])->default('Baru');
            $table->text('kebutuhan_text')->nullable();
            $table->dateTime('followup_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'sales_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
