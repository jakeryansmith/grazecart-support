<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('user_id')->unsigned()->index()->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('description', 300)->nullable();
            $table->text('body')->nullable();
            $table->text('draft_body')->nullable();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->boolean('visible')->default(false);
            $table->boolean('draft')->default(true);
            $table->string('keywords')->nullable();
            $table->string('url')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
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
        Schema::dropIfExists('guides');
    }
}
