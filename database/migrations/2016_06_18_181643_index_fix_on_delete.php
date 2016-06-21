<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndexFixOnDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropForeign('news_department_id_foreign');
            $table->foreign('department_id')
                ->references('id')->on('department')
                ->onDelete('cascade');
        });

        Schema::table('category', function (Blueprint $table) {
            $table->dropForeign('category_department_id_foreign');
            $table->foreign('department_id')
                ->references('id')->on('department')
                ->onDelete('cascade');
        });

        Schema::table('criteria', function (Blueprint $table) {
            $table->dropForeign('criteria_department_id_foreign');
            $table->foreign('department_id')
                ->references('id')->on('department')
                ->onDelete('cascade');
        });

        Schema::table('email_template', function (Blueprint $table) {
            $table->dropForeign('email_template_department_id_foreign');
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
        //
    }
}
