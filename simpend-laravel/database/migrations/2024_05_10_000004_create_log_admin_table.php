<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_admin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('pendaftaran_id');
            $table->string('aksi');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_admin');
    }
};
