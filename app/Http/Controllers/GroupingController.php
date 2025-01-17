<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Member;
use App\Models\Group;
use App\Models\Allocation;
use App\Models\Grouping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use App\Services\GroupingService;

class GroupingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $date = Carbon::today();
        $groupingData = GroupingService::getGroupingData($date);

        return Inertia::render('Grouping/Index', [
            'groupings' => $groupingData,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = Auth::id();

        $date = Carbon::today();
        $groupingData = GroupingService::getGroupingData($date);

        if (!empty($groupingData)) {
            return to_route('groupings.edit', ['user_id' => $userId, 'date' => 'today']);
        }

        $groupingData = GroupingService::getEmptyGroupingData();

        return Inertia::render('Grouping/Create', [
            'groupings' => $groupingData,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();        
        $date = Carbon::today();

        $groupings = json_decode($request->getContent(), true);
        $groups = Group::where('user_id', '=', $userId)->get();
        $members = Member::where('user_id', '=', $userId)->get();

        // チェック
        foreach ($groupings as $grouping) {
            if (!$groups->contains('id', intval($grouping['group_id']))) {
                abort(404);
            }

            if ($members->contains('id', intval($grouping['member_id']))) {
                abort(404);
            }
        }

        foreach ($groups as $group) {
            $filtered = array_filter($groupings, function ($grouping) use ($group) {
                return $grouping['group_id'] === strval($group->id);
            });
            if (empty($filtered)) {
                $deleteGroupings = Grouping::where('date', '=', $date)->where('user_id', '=', $userId)->where('group_id', '=', $group->id)->get();
                if (!$deleteGroupings->isEmpty()) {
                    foreach ($deleteGroupings as $deleteGrouping) {
                        $deleteGrouping->delete();
                    }
                }
                Grouping::create([
                    'date' => $date,
                    'user_id' => $userId,
                    'member_id' => null,
                    'group_id' => $group->id,
                ]);
            }
            else {
                $deleteGroupings = Grouping::where('date', '=', $date)->where('user_id', '=', $userId)->where('group_id', '=', $group->id)->get();
                if (!$deleteGroupings->isEmpty()) {
                    foreach ($deleteGroupings as $deleteGrouping) {
                        $deleteGrouping->delete();
                    }
                }
                foreach ($filtered as $item) {
                    Grouping::create([
                        'date' => $date,
                        'user_id' => $userId,
                        'member_id' => intval($item['member_id']),
                        'group_id' => $group->id,
                    ]);
                }
            }
        }

        return to_route('groupings.index')->with([
            'message' => '作成しました',
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $date)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, string $date)
    {
        $userId = Auth::id();

        if (intval($id) !== $userId || $date !== 'today') {
            return abort(404);
        }

        $date = Carbon::today();
        $groupingData = GroupingService::getGroupingData($date);

        return Inertia::render('Grouping/Edit', [
            'groupings' => $groupingData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $date)
    {
        
        $userId = Auth::id();
        
        if (intval($id) !== $userId || $date !== 'today') {
            return abort(404);
        }
        
        $date = Carbon::today();

        $groupings = json_decode($request->getContent(), true);
        $groups = Group::where('user_id', '=', $userId)->get();
        $members = Member::where('user_id', '=', $userId)->get();

        // チェック
        foreach ($groupings as $grouping) {
            if (!$groups->contains('id', intval($grouping['group_id']))) {
                abort(404);
            }

            if ($members->contains('id', intval($grouping['member_id']))) {
                abort(404);
            }
        }

        foreach ($groups as $group) {
            $filtered = array_filter($groupings, function ($grouping) use ($group) {
                return $grouping['group_id'] === strval($group->id);
            });
            if (empty($filtered)) {
                $deleteGroupings = Grouping::where('date', '=', $date)->where('user_id', '=', $userId)->where('group_id', '=', $group->id)->get();
                if (!$deleteGroupings->isEmpty()) {
                    foreach ($deleteGroupings as $deleteGrouping) {
                        $deleteGrouping->delete();
                    }
                }
                Grouping::create([
                    'date' => $date,
                    'user_id' => $userId,
                    'member_id' => null,
                    'group_id' => $group->id,
                ]);
            }
            else {
                $deleteGroupings = Grouping::where('date', '=', $date)->where('user_id', '=', $userId)->where('group_id', '=', $group->id)->get();
                if (!$deleteGroupings->isEmpty()) {
                    foreach ($deleteGroupings as $deleteGrouping) {
                        $deleteGrouping->delete();
                    }
                }
                foreach ($filtered as $item) {
                    Grouping::create([
                        'date' => $date,
                        'user_id' => $userId,
                        'member_id' => intval($item['member_id']),
                        'group_id' => $group->id,
                    ]);
                }
            }
        }

        return to_route('groupings.index')->with([
            'message' => '更新しました',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, string $date)
    {
        return abort(404);
    }

    public function past() {
        return Inertia::render('Grouping/Past');
    }
}
