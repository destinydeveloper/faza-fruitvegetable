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

            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('avatar')->nullable(); // Relation With Image Table
            $table->morphs('role');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->timestamp('last_activity')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });

        /**
         * Admins Table
         * ------------
         * Extra table for spesific information users level Admin
         */
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        /**
         * Customers Table
         * ------------
         * Extra table for spesific information users level Customer
         */
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        /**
         * Farmers Table
         * ------------
         * Extra table for spesific information users level Farmer
         */
        Schema::create('farmers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        /**
         * Couriers Table
         * ------------
         * Extra table for spesific information users level Courier
         */
        Schema::create('couriers', function (Blueprint $table) {
            $table->increments('id');
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
        Schema::dropIfExists('admins');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('farmers');
        Schema::dropIfExists('couriers');
    }
}
