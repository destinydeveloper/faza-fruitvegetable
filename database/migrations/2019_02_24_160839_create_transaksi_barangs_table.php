<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiBarangsTable extends Migration
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
            $table->enum('type_transaksi', ['0', '1']);
            $table->double('jumlah');
            $table->double('total');
            $table->timestamps();
            // Relasi ke barang
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
