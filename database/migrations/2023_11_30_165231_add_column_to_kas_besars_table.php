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
        Schema::table('kas_besars', function (Blueprint $table) {
            $table->bigInteger('modal_investor')->nullable()->after('no_rek');
            $table->bigInteger('modal_investor_terakhir')->after('modal_investor');
            $table->integer('nomor_deposit')->nullable()->after('uraian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kas_besars', function (Blueprint $table) {
            $table->dropColumn('modal_investor');
            $table->dropColumn('modal_investor_terakhir');
            $table->dropColumn('nomor_deposit');
        });
    }
};
