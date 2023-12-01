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
        Schema::dropIfExists('kas_gaji_komisaris_details');

        Schema::table('kas_gaji_komisaris', function (Blueprint $table) {
            $table->date('tanggal')->after('divisi_id');
            $table->string('uraian')->after('tanggal');
            $table->boolean('jenis')->after('uraian');
            $table->bigInteger('nominal_transaksi')->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kas_gaji_komisaris', function (Blueprint $table) {
            $table->dropColumn('tanggal');
            $table->dropColumn('uraian');
            $table->dropColumn('jenis');
            $table->dropColumn('nominal_transaksi');
        });
    }
};
