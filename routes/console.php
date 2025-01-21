<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Member;
use App\Models\Group;
use App\Models\Allocation;
use App\Models\Grouping;
use Illuminate\Support\Facades\Schedule;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $now = Carbon::now()->addDays(-90)->format('Y-m-d H:i:s');
    $date = Carbon::now()->addDays(-90)->format('Y-m-d');

    Member::withTrashed()->where('deleted_at', '<', $now)->forceDelete();
    Group::withTrashed()->where('deleted_at', '<', $now)->forceDelete();
    Allocation::withTrashed()->where('deleted_at', '<', $now)->forceDelete();
    Grouping::withTrashed()->where('deleted_at', '<', $now)->forceDelete();

    Grouping::withTrashed()->where('date', '<', $date)->forceDelete();
})->daily();
