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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id('teachers_id');
            $table->string('name', 255);
            $table->string('lastname', 255);
            $table->boolean('gender')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->date('registered')->nullable();
            $table->longText('avatar')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('fiscalCode', 255)->nullable();
            $table->string('telephone', 255)->nullable();
            $table->boolean('paid')->nullable();
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
        Schema::dropIfExists('teachers');
    }
};
