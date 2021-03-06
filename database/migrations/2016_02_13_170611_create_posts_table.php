<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('alias');
            $table->longText('content');
            $table->string('meta_keys')->nullable();
            $table->string('meta_desc')->nullable();
            $table->string('image')->nullable();
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->boolean('publish');
            $table->integer('author_id')->unsigned()->index();
            $table->boolean('approve');
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
