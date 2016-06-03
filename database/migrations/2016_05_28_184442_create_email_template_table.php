<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_template', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->string('name');
            $table->string('subject', 256);
            $table->text('body');
            $table->boolean('system')->default(0);

            $table->foreign('department_id')
                ->references('id')->on('department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_template', function (Blueprint $table) {
            $table->dropForeign('email_template_department_id_foreign');
        });

        Schema::drop('email_template');
    }
}
