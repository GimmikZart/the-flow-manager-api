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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payments_id');
            $table->bigInteger('value');
            $table->integer('month');
            $table->integer('year');
            $table->date('date_of_payment')->nullable();
            $table->boolean('status')->nullable();
            $table->bigInteger('course_instance_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->foreign('course_instance_id')->references('courses_students_id')->on('courses_students');
            $table->foreign('student_id')->references('students_id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
