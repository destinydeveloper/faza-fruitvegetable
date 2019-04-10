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
        Schema::table('alamat', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('keranjang', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('set null');
        });
        Schema::table('transaksi', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('alamat_id')->references('id')->on('alamat')->onDelete('cascade');
        });
        Schema::table('transaksi_barang', function (Blueprint $table) {
            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
        Schema::table('transaksi_bayar', function (Blueprint $table) {
            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
        });
        Schema::table('transaksi_konfirmasi', function (Blueprint $table) {
            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
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
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign('notifications_user_id_foreign');
        });
        Schema::table('alamat', function (Blueprint $table) {
            $table->dropForeign('alamat_user_id_foreign');
        });
        Schema::table('keranjang', function (Blueprint $table) {
            $table->dropForeign('keranjang_user_id_foreign');
            $table->dropForeign('keranjang_barang_id_foreign');
        });
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign('transaksi_user_id_foreign');
            $table->dropForeign('transaksi_alamat_id_foreign');
        });
        Schema::table('transaksi_barang', function (Blueprint $table) {
            $table->dropForeign('transaksi_barang_transaksi_id_foreign');
            $table->dropForeign('transaksi_barang_barang_id_foreign');
        });
        Schema::table('transaksi_bayar', function (Blueprint $table) {
            $table->dropForeign('transaksi_bayar_transaksi_id_foreign');
        });
        Schema::table('transaksi_konfirmasi', function (Blueprint $table) {
            $table->dropForeign('transaksi_konfirmasi_transaksi_id_foreign');
        });
    }
}
