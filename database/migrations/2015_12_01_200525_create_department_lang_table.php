<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->integer('lang_id');
            $table->string('name', 100)->nullable();
            $table->string('title', 254)->nullable();
            $table->text('description')->nullable();

            $table->foreign('department_id')
                ->references('id')->on('department')
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
        Schema::table('department_lang', function (Blueprint $table) {
            $table->dropForeign('department_lang_department_id_foreign');
        });
        Schema::drop('department_lang');
    }
}
