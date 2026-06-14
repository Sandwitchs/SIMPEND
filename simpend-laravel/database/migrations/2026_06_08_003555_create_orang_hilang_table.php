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
        Schema::create('orang_hilang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('umur');
            $table->string('lokasi_terakhir');
            $table->date('tanggal_hilang');
            $table->text('deskripsi_terakhir')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['belum ditemukan', 'ditemukan'])->default('belum ditemukan');
            $table->string('kontak_keluarga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_hilang');
    }
};
