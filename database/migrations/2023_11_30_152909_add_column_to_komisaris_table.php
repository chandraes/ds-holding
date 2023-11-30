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
        Schema::table('komisaris', function (Blueprint $table) {
            $table->integer('persen_saham')->after('no_wa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komisaris', function (Blueprint $table) {
            $table->dropColumn('persen_saham');
        });
    }
};
