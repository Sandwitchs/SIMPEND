<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gunung_id');
            $table->string('id_booking')->unique();
            $table->string('nama_ketua');
            $table->date('tanggal_pendakian');
            $table->integer('jumlah_anggota');
            $table->enum('status_verifikasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->string('dokumen_ktp');
            $table->string('dokumen_sehat');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gunung_id')->references('id')->on('gunung')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftaran');
    }
};
