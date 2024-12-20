<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('members')->insert([
            [
                'user_id' => 1,
                'name' => 'テストメンバー1',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー2',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー3',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー4',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー5',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー6',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー7',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー8',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー9',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー10',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー11',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー12',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー13',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー14',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー15',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー16',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー17',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー18',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー19',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー20',
            ],
        ]);
    }
}
