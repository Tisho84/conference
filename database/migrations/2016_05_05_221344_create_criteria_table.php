<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->integer('type_id')->unsigned()->default(1); #no index
            $table->text('vars');
            $table->integer('sort')->default(1);

            $table->foreign('department_id')
                ->references('id')->on('department');
        });

        Schema::create('criteria_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('criteria_id')->unsigned();
            $table->integer('lang_id');
            $table->string('title', 254)->nullable();

            $table->foreign('criteria_id')
                ->references('id')->on('criteria')
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
        Schema::table('criteria', function (Blueprint $table) {
            $table->dropForeign('criteria_department_id_foreign');
        });

        Schema::table('criteria_lang', function (Blueprint $table) {
            $table->dropForeign('criteria_lang_criteria_id_foreign');
        });

        Schema::drop('criteria');
        Schema::drop('criteria_lang');
    }
}
