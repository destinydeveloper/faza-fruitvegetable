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
            $table->foreign('gambar_id')->references('id')->on('gambar')->onDelete('cascade');
        });
        Schema::table('gambar_barang', function (Blueprint $table) {
            $table->foreign('gambar_id')->references('id')->on('gambar')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
        Schema::table('barang_mentah', function (Blueprint $table) {
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('gaji_karyawan', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_gambar_id_foreign');
        });
        Schema::table('gambar_barang', function (Blueprint $table) {
            $table->dropForeign('gambar_barang_gambar_id_foreign');
            $table->dropForeign('gambar_barang_barang_id_foreign');
        });
        Schema::table('barang_mentah', function (Blueprint $table) {
            $table->dropForeign('barang_mentah_barang_id_foreign');
            $table->dropForeign('barang_mentah_user_id_foreign');
        });
        Schema::table('gaji_karyawan', function (Blueprint $table) {
            $table->dropForeign('gaji_karyawan_user_id_foreign');
        });
        Schema::table('gaji_karyawan', function (Blueprint $table) {
            $table->dropForeign('notifications_user_id_foreign');
        });
    }
}
