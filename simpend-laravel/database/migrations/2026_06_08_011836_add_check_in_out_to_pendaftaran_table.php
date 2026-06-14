<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->enum('status_pendakian', ['belum_mendaki', 'sedang_mendaki', 'selesai', 'overdue'])
                  ->default('belum_mendaki')
                  ->after('status_pembayaran');
            $table->timestamp('tanggal_check_in')->nullable()->after('status_pendakian');
            $table->timestamp('tanggal_check_out')->nullable()->after('tanggal_check_in');
        });
    }

    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['status_pendakian', 'tanggal_check_in', 'tanggal_check_out']);
        });
    }
};
