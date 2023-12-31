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
        Schema::create('kas_kecils', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nota')->nullable();
            $table->string('uraian')->nullable();
            $table->boolean('jenis');
            $table->bigInteger('nominal_transaksi');
            $table->bigInteger('saldo');
            $table->string('nama_rek');
            $table->string('bank')->nullable();
            $table->string('no_rek')->nullable();
            $table->boolean('void');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_kecils');
    }
};
