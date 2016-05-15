<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriaPaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criteria_paper', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('criteria_id')->unsigned();
            $table->integer('paper_id')->unsigned();
            $table->text('value');

            $table->foreign('paper_id')
                ->references('id')->on('paper')
                ->onDelete('cascade');
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
        Schema::table('criteria_paper', function (Blueprint $table) {
            $table->dropForeign('criteria_paper_paper_id_foreign');
            $table->dropForeign('criteria_paper_criteria_id_foreign');
        });
        Schema::drop('criteria_paper');
    }
}
