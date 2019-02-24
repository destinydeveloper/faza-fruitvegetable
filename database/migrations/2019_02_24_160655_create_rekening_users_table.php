<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekeningUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('atas_nama', 25);
            $table->string('nama_bank', 25);
            $table->string('no_rekening', 20);
            $table->timestamps();

            // relasi ke pelanggan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekening_user');
    }
}
