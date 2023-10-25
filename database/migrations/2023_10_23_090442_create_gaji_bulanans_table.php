<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gaji_bulanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jukir_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('cashPajak')->default(0);
            $table->integer('cashUpah')->default(0);
            $table->string('bulan');
            $table->string('statusUpah')->default('Belum menerima upah');
            $table->string('statusPajak')->default('Belum memberi pajak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_bulanans');
    }
};
