<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #default pivot table user type access data
        #user_type_id, access_id
        $data = [
            ['user_type_id' => 1, 'access_id' => 1],
            ['user_type_id' => 2, 'access_id' => 2],
            ['user_type_id' => 10 , 'access_id' => 1],
            ['user_type_id' => 10 , 'access_id' => 2],
            ['user_type_id' => 10 , 'access_id' => 3],
            ['user_type_id' => 10 , 'access_id' => 4],
            ['user_type_id' => 10 , 'access_id' => 9],
            ['user_type_id' => 10 , 'access_id' => 10],
            ['user_type_id' => 100, 'access_id' => 1],
            ['user_type_id' => 100, 'access_id' => 2],
            ['user_type_id' => 100, 'access_id' => 3],
            ['user_type_id' => 100, 'access_id' => 4],
            ['user_type_id' => 100, 'access_id' => 9],
            ['user_type_id' => 100, 'access_id' => 10],
            ['user_type_id' => 100, 'access_id' => 100],
        ];

        DB::table('user_type_access')->truncate();
        DB::table('user_type_access')->insert($data);
    }
}
