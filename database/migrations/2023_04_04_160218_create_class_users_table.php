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
        // bảng trung gian giữa lớp học phần và sinh viên
        Schema::create('class_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_user');
            $table->unsignedInteger('id_class');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_class')->references('id')->on('classes');
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
        Schema::dropIfExists('class_users');
    }
};
