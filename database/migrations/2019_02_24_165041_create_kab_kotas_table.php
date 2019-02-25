<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKabKotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kab_kota', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 25);
            $table->integer('kode');
            $table->unsignedInteger('id_provinsi');
            $table->timestamps();

            $table->foreign('id_provinsi')->references('id')->on('provinsi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('kab_kota');
    }
}
