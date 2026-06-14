<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gunung', function (Blueprint $table) {
            $table->integer('harga_per_orang')->default(50000);
        });
    }

    public function down()
    {
        Schema::table('gunung', function (Blueprint $table) {
            $table->dropColumn('harga_per_orang');
        });
    }
};
