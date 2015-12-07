<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorColumnToDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('department', function (Blueprint $table) {
            $table->string('theme_color', 10)
                ->default('#ffffff')
                ->after('image');
            $table->string('theme_background_color', 10)
                ->default('#7f7f7f')
                ->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department', function (Blueprint $table) {
            $table->dropColumn('theme_color');
            $table->dropColumn('theme_background_color');
        });
    }
}
