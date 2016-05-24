<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchingWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matching_words', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pic_id');
            $table->integer('tag_id');
            $table->integer('first_user_id');
            $table->integer('second_user_id');
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
        Schema::drop('matching_words');
    }
}
