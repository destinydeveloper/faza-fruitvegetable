<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRelationRekeningUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekening_user', function (Blueprint $table) {
            $table->unsignedInteger('id_pelanggan')->after('id')->nullable()->index();

            $table->foreign('id_pelanggan')->references('id')->on('pelanggan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekening_user', function (Blueprint $table) {
            //
        });
    }
}
