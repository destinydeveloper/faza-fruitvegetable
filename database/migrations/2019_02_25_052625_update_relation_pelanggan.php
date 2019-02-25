<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRelationPelanggan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            // $table->unsignedInteger('id_kab_kota')->after('foto')->nullable()->index();
            // $table->unsignedInteger('id_provinsi')->after('id_kab_kota')->nullable()->index();

            $table->foreign('id_kab_kota')->references('id')->on('kab_kota')->onDelete('cascade');
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
        Schema::table('pelanggan', function (Blueprint $table) {
            //
        });
    }
}
