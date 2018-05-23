<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorQualification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tutor_qualitification', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->increments('id');
            $table->integer('tutor_id')->unsigned()->index();
            $table->integer('institute_id')->unsigned()->index();
            $table->string('degree_title');
            $table->string('degree_image');
            $table->unsignedTinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('tbl_tutor_qualitification');
    }
}
