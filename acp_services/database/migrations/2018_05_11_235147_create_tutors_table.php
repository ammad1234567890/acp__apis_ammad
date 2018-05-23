<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tutor', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('role_id')->unsigned()->index();

            //Personal Information
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('gender', 8)->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('cnic', 20)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('map_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('tag_line')->nullable();
            $table->string('short_desc')->nullable();
            $table->string('over_view')->nullable();
            $table->string('phone')->nullable();
            $table->integer('hourly_rate')->unsigned()->nullable();
            $table->integer('profile_views')->unsigned()->nullable();
            $table->string('intro_clip')->nullable();

            //Location
            $table->integer('country_id')->unsigned()->index()->nullable();
            $table->integer('state_id')->unsigned()->index()->nullable();
            $table->integer('city_id')->unsigned()->index()->nullable();
            $table->string('zipcode')->nullable();

            // Social information
            $table->string('whatsapp_number')->nullable();
            $table->string('skype_reference')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_pinterest')->nullable();
            $table->string('social_googlePlus')->nullable();
            $table->string('social_instagram')->nullable();

            $table->unsignedTinyInteger('is_active')->default(1);
            $table->unsignedTinyInteger('is_deleted')->default(0);

            $table->foreign('role_id')->references('id')->on('tbl_roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('tbl_country')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('tbl_state')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('tbl_city')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_tutor');
    }
}
