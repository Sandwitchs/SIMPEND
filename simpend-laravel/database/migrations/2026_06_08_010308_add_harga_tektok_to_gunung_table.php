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
        Schema::table('gunung', function (Blueprint $table) {
            $table->integer('harga_per_orang_tektok')->default(0)->after('harga_per_orang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gunung', function (Blueprint $table) {
            $table->dropColumn('harga_per_orang_tektok');
        });
    }
};
