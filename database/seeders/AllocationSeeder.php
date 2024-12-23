<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('allocations')->insert([
            [
                'user_id' => 1,
                'group_id' => 1,
                'allocatable' => true,
            ],
            [
                'user_id' => 1,
                'group_id' => 2,
                'allocatable' => true,
            ],
            [
                'user_id' => 1,
                'group_id' => 3,
                'allocatable' => true,
            ],
            [
                'user_id' => 2,
                'group_id' => 1,
                'allocatable' => false,
            ],
            [
                'user_id' => 2,
                'group_id' => 2,
                'allocatable' => true,
            ],
            [
                'user_id' => 2,
                'group_id' => 3,
                'allocatable' => true,
            ],
            [
                'user_id' => 3,
                'group_id' => 1,
                'allocatable' => true,
            ],
            [
                'user_id' => 3,
                'group_id' => 2,
                'allocatable' => true,
            ],
            [
                'user_id' => 3,
                'group_id' => 3,
                'allocatable' => false,
            ],
        ]);
    }
}
