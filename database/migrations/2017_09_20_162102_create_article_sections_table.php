<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('slug')->unique();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->mediumText('body')->nullable();
            $table->string('keywords')->nullable();
            $table->string('url')->nullable();
            $table->boolean('visible')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('article_id')
                ->references('id')->on('articles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_sections');
    }
}
