<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('anggota_pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_id');
            $table->string('nama');
            $table->string('no_ktp');
            $table->integer('usia');
            $table->string('no_hp');
            $table->timestamps();

            $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_pendaftaran');
    }
};
