<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTypeAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type_access', function (Blueprint $table) {
            $table->integer('user_type_id')->unsigned();
            $table->integer('access_type_id');

            $table->foreign('user_type_id')->references('id')->on('user_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_type_access', function (Blueprint $table) {
           $table->dropForeign('user_type_access_user_type_id_foreign');
        });
        Schema::drop('user_type_access');
    }
}
