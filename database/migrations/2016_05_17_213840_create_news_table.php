<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->integer('active')->default(1);
            $table->integer('sort');
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')->on('department');

        });

        Schema::create('news_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('news_id')->unsigned();
            $table->integer('lang_id');
            $table->string('title', 256);
            $table->text('description');

            $table->foreign('news_id')
                ->references('id')->on('news')
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
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign('news_department_id_foreign');
        });

        Schema::table('news_lang', function (Blueprint $table) {
            $table->dropForeign('news_lang_news_id_foreign');
        });

        Schema::drop('news');
        Schema::drop('news_lang');
    }
}
