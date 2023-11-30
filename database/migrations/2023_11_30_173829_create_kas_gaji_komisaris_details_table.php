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
        Schema::create('kas_gaji_komisaris_details', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('divisi_id')->constrained('divisis')->onDelete('cascade');
            $table->string('uraian')->nullable();
            $table->bigInteger('nominal_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_gaji_komisaris_details');
    }
};
