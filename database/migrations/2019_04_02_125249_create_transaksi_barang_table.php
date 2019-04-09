<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaksi_id')->unsigned();
            $table->integer('barang_id')->unsigned();
            $table->integer('stok');
            $table->text('catatan')->nullable();
            $table->double('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_barang');
    }
}