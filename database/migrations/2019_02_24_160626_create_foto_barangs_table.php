<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voids
     */
    public function up()
    {
        Schema::create('foto_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->text('foto_barang');
            $table->timestamps();
            // relasi ke tabel barang

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foto_barang');
    }
}
