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
        Schema::create('users', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index();
            $table->string('username')->unique()->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->integer('verification_code')->nullable();
            $table->string('password');
            $table->unsignedTinyInteger('is_active')->default(1);
            $table->unsignedTinyInteger('is_deleted')->default(0);
            $table->foreign('role_id')->references('id')->on('tbl_roles')->onDelete('cascade');
            $table->rememberToken();
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
    }
}
