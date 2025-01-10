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
                'member_id' => 1,
                'group_id' => 1,
                'allocatable' => true,
            ],
            [
                'member_id' => 1,
                'group_id' => 2,
                'allocatable' => true,
            ],
            [
                'member_id' => 1,
                'group_id' => 3,
                'allocatable' => true,
            ],
            [
                'member_id' => 1,
                'group_id' => 4,
                'allocatable' => true,
            ],
            [
                'member_id' => 1,
                'group_id' => 5,
                'allocatable' => true,
            ],
            [
                'member_id' => 2,
                'group_id' => 1,
                'allocatable' => true,
            ],
            [
                'member_id' => 2,
                'group_id' => 2,
                'allocatable' => true,
            ],
            [
                'member_id' => 2,
                'group_id' => 3,
                'allocatable' => true,
            ],
            [
                'member_id' => 2,
                'group_id' => 4,
                'allocatable' => true,
            ],
            [
                'member_id' => 2,
                'group_id' => 5,
                'allocatable' => true,
            ],
            [
                'member_id' => 3,
                'group_id' => 1,
                'allocatable' => true,
            ],
            [
                'member_id' => 3,
                'group_id' => 2,
                'allocatable' => true,
            ],
            [
                'member_id' => 3,
                'group_id' => 3,
                'allocatable' => true,
            ],
            [
                'member_id' => 3,
                'group_id' => 4,
                'allocatable' => true,
            ],
            [
                'member_id' => 3,
                'group_id' => 5,
                'allocatable' => true,
            ],
            [
                'member_id' => 4,
                'group_id' => 1,
                'allocatable' => true,
            ],
            [
                'member_id' => 4,
                'group_id' => 2,
                'allocatable' => true,
            ],
            [
                'member_id' => 4,
                'group_id' => 3,
                'allocatable' => true,
            ],
            [
                'member_id' => 4,
                'group_id' => 4,
                'allocatable' => true,
            ],
            [
                'member_id' => 4,
                'group_id' => 5,
                'allocatable' => true,
            ],
            [
                'member_id' => 5,
                'group_id' => 1,
                'allocatable' => true,
            ],
            [
                'member_id' => 5,
                'group_id' => 2,
                'allocatable' => true,
            ],
            [
                'member_id' => 5,
                'group_id' => 3,
                'allocatable' => true,
            ],
            [
                'member_id' => 5,
                'group_id' => 4,
                'allocatable' => true,
            ],
            [
                'member_id' => 5,
                'group_id' => 5,
                'allocatable' => true,
            ],
            // [
            //     'member_id' => 6,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 6,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 6,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 6,
            //     'group_id' => 4,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 6,
            //     'group_id' => 5,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 7,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 7,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 7,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 7,
            //     'group_id' => 4,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 7,
            //     'group_id' => 5,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 8,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 8,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 8,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 8,
            //     'group_id' => 4,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 8,
            //     'group_id' => 5,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 9,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 9,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 9,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 9,
            //     'group_id' => 4,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 9,
            //     'group_id' => 5,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 10,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 10,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 10,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 10,
            //     'group_id' => 4,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 10,
            //     'group_id' => 5,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 11,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 11,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 11,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 12,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 12,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 12,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 13,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 13,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 13,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 14,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 14,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 14,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 15,
            //     'group_id' => 1,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 15,
            //     'group_id' => 2,
            //     'allocatable' => true,
            // ],
            // [
            //     'member_id' => 15,
            //     'group_id' => 3,
            //     'allocatable' => true,
            // ],
        ]);
    }
}
