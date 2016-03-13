<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'id' => 1,
                'title' => 'Author',
                'sort' => 1,
                'active' => 1,
                'is_default' => 1
            ],
            [
                'id' => 2,
                'title' => 'Reviewer',
                'sort' => 2,
                'active' => 1,
                'is_default' => 1
            ],
            [
                'id' => 10,
                'title' => 'Admin Department',
                'sort' => 10,
                'active' => 1,
                'is_default' => 1
            ],
            [
                'id' => 100,
                'title' => 'System Admin',
                'sort' => 100,
                'active' => 1,
                'is_default' => 1
            ],
        ];
        DB::table('user_type')->truncate();
        DB::table('user_type')->insert($types);
    }
}
