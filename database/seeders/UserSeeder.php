<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'テスト1事業所',
                'email' => 'test1@test.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'テスト2事業所',
                'email' => 'test2@test.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'テスト3事業所',
                'email' => 'test3@test.com',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
