<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('gambar_id')->references('id')->on('gambar');
        });
        Schema::table('gambar_barang', function (Blueprint $table) {
            $table->foreign('gambar_id')->references('id')->on('gambar');
            $table->foreign('barang_id')->references('id')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign('users_gambar_id_foreign');
        $table->dropForeign('gambar_barang_gambar_id_foreign');
        $table->dropForeign('gambar_barang_barang_id_foreign');
    }
}
