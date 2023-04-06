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
        // bảng lớp học phần
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_class');
            $table->string('code_class');
            $table->unsignedInteger('id_subject'); // id mon hoc
            $table->unsignedInteger('id_semester'); // id ky hoc
            $table->foreign('id_subject')->references('id')->on('subjects');
            $table->foreign('id_semester')->references('id')->on('semesters');
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
        Schema::dropIfExists('classes');
    }
};
