<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_keluar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_penerima', 25);
            $table->string('telepon_penerima', 15);
            $table->string('kode_pos_penerima', 7);
            $table->string('alamat_penerima', 50);

            $table->timestamps();

            // relasi ke user
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_keluar');
    }
}
