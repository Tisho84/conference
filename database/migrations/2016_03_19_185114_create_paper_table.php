<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->default(1); #no index
            $table->string('source', 100);
            $table->string('title');
            $table->string('description', 1000);
            $table->string('authors', 1000);
            $table->boolean('archived')->default(0);
            $table->boolean('payment_confirmed')->default(0);
            $table->string('payment_source', 100);
            $table->string('payment_description', 1000);
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')->on('department');
            $table->foreign('category_id')
                ->references('id')->on('category');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('reviewer_id')
                ->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paper', function (Blueprint $table) {
            $table->dropForeign('paper_department_id_foreign');
            $table->dropForeign('paper_category_id_foreign');
            $table->dropForeign('paper_user_id_foreign');
            $table->dropForeign('paper_reviewer_id_foreign');
        });
        Schema::drop('paper');
    }
}
