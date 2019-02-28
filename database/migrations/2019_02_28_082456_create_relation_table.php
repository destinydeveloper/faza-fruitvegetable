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
            $table->foreign('avatar')->references('id')->on('images');
        });
        Schema::table('image_goods', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('images');
            $table->foreign('goods_id')->references('id')->on('goods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign('users_avatar_foreign');
        $table->dropForeign('image_goods_image_id_foreign');
        $table->dropForeign('image_goods_goods_id_foreign');
    }
}
