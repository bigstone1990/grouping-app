<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GroupingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today();
        DB::table('groupings')->insert([
            [
                'date' => $today,
                'user_id' => 1,
                'member_id' => 1,
                'group_id' => 1,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'member_id' => 2,
                'group_id' => 1,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'member_id' => 3,
                'group_id' => 2,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'member_id' => 4,
                'group_id' => 2,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'member_id' => 5,
                'group_id' => 3,
            ],
        ]);
    }
}
