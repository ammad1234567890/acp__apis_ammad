<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorExpertise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_tutor_expertise', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->increments('id');
            $table->integer('sub_cat_id')->unsigned()->index();
            $table->integer('sub_subcat_id')->unsigned()->index();
            $table->integer('tutor_id')->unsigned()->index();
            $table->unsignedTinyInteger('is_deleted')->default(0);
            $table->foreign('sub_cat_id')->references('id')->on('tbl_subject_category')->onDelete('cascade');
            $table->foreign('sub_subcat_id')->references('id')->on('tbl_subject_sub_category')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_tutor_expertise');
    }
}
