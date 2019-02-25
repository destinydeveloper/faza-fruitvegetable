<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRelationTransaksiKeluar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_keluar', function (Blueprint $table) {
            $table->unsignedInteger('id_user')->after('id')->nullable()->index();
            $table->unsignedInteger('id_kurir')->after('alamat_penerima')->nullable()->index();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kurir')->references('id')->on('kurir')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_keluar', function (Blueprint $table) {
            //
        });
    }
}
