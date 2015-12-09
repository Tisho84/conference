<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->integer('lang_id');
            $table->string('name', 100)->nullable();

            $table->foreign('category_id')
                ->references('id')->on('category')
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
        Schema::table('category_lang', function (Blueprint $table) {
            $table->dropForeign('category_lang_category_id_foreign');
        });

        Schema::drop('category_lang');
    }
}
