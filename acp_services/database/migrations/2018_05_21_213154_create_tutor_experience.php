<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorExperience extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tutor_experience', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->increments('id');         
            $table->integer('tutor_id')->unsigned()->index();
            $table->integer('experience_type_id')->unsigned()->index();
            $table->integer('institute_id')->unsigned()->index();
            $table->date('from_date');
            $table->date('to_date');
            $table->string('short_description');
            $table->unsignedTinyInteger('is_currently_work')->default(0);
            $table->unsignedTinyInteger('is_deleted')->default(0);
            $table->foreign('experience_type_id')->references('id')->on('tbl_experience_type')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('tbl_tutor')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_tutor_experience');
    }
}
