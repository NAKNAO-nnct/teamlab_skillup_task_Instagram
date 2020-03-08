<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbs', function (Blueprint $table) {
            // 記事ID
            $table->bigIncrements('article_id');
            // 投稿ユーザID
            $table->string('github_id');
            // いいねしたID
            $table->string('favorite_github_id')->nullable();
            // 投稿内容
            $table->json('contents');
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
        Schema::dropIfExists('bbs');
    }
}
