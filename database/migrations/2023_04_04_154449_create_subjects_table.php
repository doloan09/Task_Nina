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
        // bảng môn học
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_subject');
            $table->string('code_subject'); // ma mon hoc
            $table->integer('number_of_credits'); // so tin chi
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
        Schema::dropIfExists('subjects');
    }
};
