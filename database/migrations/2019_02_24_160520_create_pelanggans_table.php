<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 25);
            $table->string('alamat', 50);
            $table->enum('jk', ['L', 'P']);
            $table->string('telepon', 15);
            $table->string('email')->unique();
            $table->string('username', 20);
            $table->string('password');
            $table->text('foto');
            $table->timestamps();

            // relasi ke kab_kota dan provinsi
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pelanggan');
    }
}
