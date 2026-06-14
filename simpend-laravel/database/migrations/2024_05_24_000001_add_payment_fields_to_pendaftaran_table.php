<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->integer('total_harga')->default(0);
        });
    }

    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'total_harga']);
        });
    }
};
