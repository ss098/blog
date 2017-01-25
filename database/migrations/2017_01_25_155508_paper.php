<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Paper extends Migration
{
    /**
     * 创建文章表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('markdown');
            $table->text('content');
            $table->tinyInteger('page');
            $table->integer('category_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * 删除文章表
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers');
    }
}
