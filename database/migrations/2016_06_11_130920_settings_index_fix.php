<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsIndexFix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign('settings_department_id_foreign');
            $table->foreign('department_id')
                ->references('id')->on('department')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign('settings_department_id_foreign');
            $table->foreign('department_id')
                ->references('id')->on('department');
        });
    }
}
