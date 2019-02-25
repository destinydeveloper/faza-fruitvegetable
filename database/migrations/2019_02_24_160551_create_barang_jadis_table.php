<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBarangJadisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_jadi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('berat');
            $table->integer('harga');
            $table->enum('status', ['0', '1']);
            $table->string('satuan', 10);
            $table->string('deskripsi', 50);
            $table->timestamps();
            // Relasi jenis
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_jadi');
    }
}
