<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Users Table 
         * -----------
         * Main Table For Auth All Users
         */
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nama');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('gambar_id')->unsigned()->nullable();

            $table->morphs('role');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->timestamp('aktifitas_terakhir')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });

        /**
         * Admins Table
         * ------------
         * Extra table for spesific information users level Admin
         */
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        /**
         * Customers Table
         * ------------
         * Extra table for spesific information users level Customer
         */
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        /**
         * Farmers Table
         * ------------
         * Extra table for spesific information users level Farmer
         */
        Schema::create('petani', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        /**
         * Couriers Table
         * ------------
         * Extra table for spesific information users level Courier
         */
        Schema::create('kurir', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });


        Schema::create('investor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
        Schema::create('pengepak', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
        Schema::create('supervisor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('pelanggan');
        Schema::dropIfExists('petani');
        Schema::dropIfExists('kurir');
        Schema::dropIfExists('investor');
        Schema::dropIfExists('pengepak');
        Schema::dropIfExists('supervisor');
    }
}
