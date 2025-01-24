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
                'kana' => 'てすとめんばー1',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー2',
                'kana' => 'てすとめんばー2',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー3',
                'kana' => 'てすとめんばー3',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー4',
                'kana' => 'てすとめんばー4',
            ],
            [
                'user_id' => 1,
                'name' => 'テストメンバー5',
                'kana' => 'てすとめんばー5',
            ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー6',
            //     'kana' => 'てすとめんばー6',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー7',
            //     'kana' => 'てすとめんばー7',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー8',
            //     'kana' => 'てすとめんばー8',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー9',
            //     'kana' => 'てすとめんばー9',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー10',
            //     'kana' => 'てすとめんばー10',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー11',
            //     'kana' => 'てすとめんばー11',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー12',
            //     'kana' => 'てすとめんばー12',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー13',
            //     'kana' => 'てすとめんばー13',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー14',
            //     'kana' => 'てすとめんばー14',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー15',
            //     'kana' => 'てすとめんばー15',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー16',
            //     'kana' => 'てすとめんばー16',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー17',
            //     'kana' => 'てすとめんばー17',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー18',
            //     'kana' => 'てすとめんばー18',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー19',
            //     'kana' => 'てすとめんばー19',
            // ],
            // [
            //     'user_id' => 1,
            //     'name' => 'テストメンバー20',
            //     'kana' => 'てすとめんばー20',
            // ],
        ]);
    }
}
