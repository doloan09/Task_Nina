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
        Schema::table('users', function (Blueprint $table){
            $table->string('code_user'); // mã sinh viên - mã nhân viên
            $table->date('date_of_birth');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('sex')->nullable(); // giới tính
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('code');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('sex');
            $table->dropColumn('avatar');
        });
    }

};
