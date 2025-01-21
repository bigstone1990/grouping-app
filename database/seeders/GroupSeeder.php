<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('groups')->insert([
            [
                'user_id' => 1,
                'name' => 'テストグループ1',
                'order' => 1,
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ2',
                'order' => 2,
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ3',
                'order' => 3,
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ4',
                'order' => 4,
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ5',
                'order' => 5,
            ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストグループ6',
            //     'order' => 6,
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストグループ7',
            //     'order' => 7,
            // ],
        ]);
    }
}
