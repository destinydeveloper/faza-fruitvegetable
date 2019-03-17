<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('nama');
            $table->integer('berat');
            $table->integer('harga');
            $table->enum('jenis', ['sayur', 'buah']);
            $table->longText('catatan')->nullable();
            $table->integer('stok')->default(0);
            $table->enum('status', [0, 1])->default(1);
            $table->string('satuan_berat')->default('gram');
            $table->string('satuan_stok')->default('stok');
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
        Schema::dropIfExists('barang');
    }
}
