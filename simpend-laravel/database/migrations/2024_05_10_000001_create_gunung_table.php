<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gunung', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gunung');
            $table->string('jalur');
            $table->integer('kuota_maks');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gunung');
    }
};
