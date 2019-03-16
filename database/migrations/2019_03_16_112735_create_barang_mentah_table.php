<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangMentahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_mentah', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('nama');
            $table->integer('berat');
            $table->integer('harga');
            $table->longText('catatan')->nullable();
            $table->integer('stok')->default(0);
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
        Schema::dropIfExists('barang_mentah');
    }
}
