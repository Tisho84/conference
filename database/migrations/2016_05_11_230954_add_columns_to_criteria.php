<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->boolean('required')->default(0)->after('type_id');
            $table->boolean('visible')->default(0)->after('type_id');
            $table->boolean('admin')->default(0)->after('type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->dropColumn('required');
            $table->dropColumn('visible');
            $table->dropColumn('admin');
        });
    }
}
