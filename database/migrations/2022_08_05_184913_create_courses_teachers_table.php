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
        Schema::create('courses_teachers', function (Blueprint $table) {
            $table->id('courses_teachers_id');
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->foreign('teacher_id')->references('teachers_id')->on('teachers');
            $table->foreign('course_id')->references('courses_id')->on('courses');
            $table->boolean('active');
            $table->integer('type');
            $table->float('work_hours');
            $table->integer('unit');
            $table->date('start_date');
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_teachers');
    }
};
