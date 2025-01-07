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
        $pastDay1 = Carbon::today()->addDays(-1);
        $pastDay2 = Carbon::today()->addDays(-2);
        $pastDay3 = Carbon::today()->addDays(-3);
        $pastDay4 = Carbon::today()->addDays(-4);
        $pastDay5 = Carbon::today()->addDays(-5);
        $pastDay6 = Carbon::today()->addDays(-6);
        $pastDay7 = Carbon::today()->addDays(-7);
        $pastDay8 = Carbon::today()->addDays(-8);
        DB::table('groupings')->insert([
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 1,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 2,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 3,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 4,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 5,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 6,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 7,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 8,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 9,
            ],
            [
                'date' => $today,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 10,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 10,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 9,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 8,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 7,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 6,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 5,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 4,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 3,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 2,
            ],
            [
                'date' => $pastDay1,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 1,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 1,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 2,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 3,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 4,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 5,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 6,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 7,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 8,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 9,
            ],
            [
                'date' => $pastDay2,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 10,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 1,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 3,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 5,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 7,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 9,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 2,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 4,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 6,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 8,
            ],
            [
                'date' => $pastDay3,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 10,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 2,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 4,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 6,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 8,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 10,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 1,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 3,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 5,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 7,
            ],
            [
                'date' => $pastDay4,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 9,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => null,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 1,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 2,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 3,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 4,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 5,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => null,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 6,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 7,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 8,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 9,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 10,
            ],
            [
                'date' => $pastDay5,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => null,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 1,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 2,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 3,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => null,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 4,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 5,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 6,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => null,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 7,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 8,
            ],
            [
                'date' => $pastDay6,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 9,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => null,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => null,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 1,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 2,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 3,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 4,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 5,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => null,
            ],
            [
                'date' => $pastDay7,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => null,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 1,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 1,
                'member_id' => 2,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 3,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 2,
                'member_id' => 4,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 5,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 3,
                'member_id' => 6,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 7,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 4,
                'member_id' => 8,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 9,
            ],
            [
                'date' => $pastDay8,
                'user_id' => 1,
                'group_id' => 5,
                'member_id' => 10,
            ],
        ]);
    }
}
