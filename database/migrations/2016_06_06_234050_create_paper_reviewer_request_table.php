<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaperReviewerRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_reviewer_request', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('paper_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('paper_id')->references('id')->on('paper')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paper_reviewer_request', function (Blueprint $table) {
            $table->dropForeign('paper_reviewer_request_user_id_foreign');
            $table->dropForeign('paper_reviewer_request_paper_id_foreign');
        });
        Schema::drop('paper_reviewer_request');
    }
}
