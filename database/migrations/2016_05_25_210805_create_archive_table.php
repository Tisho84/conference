<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archive', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->string('name')->unique();
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')->on('department');
        });

        Schema::table('paper', function (Blueprint $table) {
            $table->unsignedInteger('archive_id')->nullable()->after('status_id');
            $table->dropColumn('archived');

            $table->foreign('archive_id')
                ->references('id')->on('archive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archive', function (Blueprint $table) {
            $table->dropForeign('archive_department_id_foreign');
            $table->dropUnique('archive_name_unique');
        });

        Schema::table('paper', function (Blueprint $table) {
            $table->dropForeign('paper_archive_id_foreign');
            $table->dropColumn('archive_id');
            $table->integer('archived');
        });

        Schema::drop('archive');
    }
}
