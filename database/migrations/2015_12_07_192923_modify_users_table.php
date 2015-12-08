<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('department_id')->unsigned()->after('id');
            $table->integer('user_type_id')->unsigned()->after('department_id');
            $table->integer('rank_id')->default(0)->after('user_type_id'); #no index
            $table->integer('country_id')->after('rank_id'); #no index
            $table->string('email2')->nullable()->after('email');
            $table->string('phone', 30)->nullable()->after('email2');
            $table->string('address')->after('phone');
            $table->string('institution', 100)->after('address');
            $table->boolean('active')->default(1)->after('institution');

            $table->foreign('department_id')
                ->references('id')->on('department');
            $table->foreign('user_type_id')
                ->references('id')->on('user_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_department_id_foreign');
            $table->dropForeign('users_user_type_id_foreign');
            $table->dropColumn(['department_id', 'user_type_id', 'rank_id', 'country_id', 'email2',
                'phone', 'address', 'institution', 'active']
            );
        });
    }
}
