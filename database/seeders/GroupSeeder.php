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
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ2',
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ3',
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ4',
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ5',
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ6',
            ],
            [
                'user_id' => 1,
                'name' => 'テストグループ7',
            ],
        ]);
    }
}
