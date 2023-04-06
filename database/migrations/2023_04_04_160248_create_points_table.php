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
        // bảng điểm của sinh viên
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('score_component'); // điểm thành phần
            $table->integer('score_test'); // điểm thi
            $table->integer('score_final'); // điểm tong ket
            $table->unsignedBigInteger('id_user');  // id sinh vien
            $table->unsignedInteger('id_class'); // id lop hoc phan
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
        Schema::dropIfExists('points');
    }
};
