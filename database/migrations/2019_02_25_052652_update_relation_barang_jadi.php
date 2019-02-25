<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRelationBarangJadi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang_jadi', function (Blueprint $table) {
            $table->unsignedInteger('id_jenis')->after('id')->nullable()->index();

            $table->foreign('id_jenis')->references('id')->on('jenis_barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang_jadi', function (Blueprint $table) {
            //
        });
    }
}
