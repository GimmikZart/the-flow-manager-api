<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id('salaries_id');
            $table->bigInteger('value')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->boolean('type');
            $table->date('date_of_payment')->nullable();
            $table->boolean('status')->nullable();
            $table->bigInteger('course_instance_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->foreign('course_instance_id')->references('courses_teachers_id')->on('courses_teachers');
            $table->foreign('teacher_id')->references('teachers_id')->on('teachers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};
