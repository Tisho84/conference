<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypeLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type_lang', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_type_id')->unsigned();
            $table->string('name', 100)->nullable();

            $table->foreign('user_type_id')
                ->references('id')->on('user_type')
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
        Schema::table('user_type_lang', function (Blueprint $table) {
            $table->dropForeign('user_type_lang_user_type_id_foreign');
        });
        Schema::drop('user_type_lang');
    }
}
