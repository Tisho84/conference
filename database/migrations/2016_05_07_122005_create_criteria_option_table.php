<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriaOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria_option', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('criteria_id')->unsigned();
            $table->integer('sort')->default(1);

            $table->foreign('criteria_id')
                ->references('id')->on('criteria')
                ->onDelete('cascade');
        });

        Schema::create('criteria_option_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('option_id')->unsigned();
            $table->integer('lang_id');
            $table->string('title', 254)->nullable();

            $table->foreign('option_id')
                ->references('id')->on('criteria_option')
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
        Schema::table('criteria_option', function (Blueprint $table) {
            $table->dropForeign('criteria_option_criteria_id_foreign');
        });

        Schema::table('criteria_option_lang', function (Blueprint $table) {
            $table->dropForeign('criteria_option_lang_option_id_foreign');
        });

        Schema::drop('criteria_option');
        Schema::drop('criteria_option_lang');
    }
}
