<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * 创建用户表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('token');
            $table->timestamps();
        });
    }

    /**
     * 删除用户表
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
