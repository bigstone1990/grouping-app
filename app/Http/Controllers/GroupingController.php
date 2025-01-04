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
        $userId = Auth::id();

        $members = DB::table('members')
        ->selectRaw('id as members_id, name as members_name')
        ->where('user_id', '=', $userId)
        ->whereNull('deleted_at');

        $groupings = DB::table('groupings')
        ->selectRaw('id as groupings_id, date as groupings_date, member_id as groupings_member_id, group_id as groupings_group_id')
        ->where('date', $date)
        ->where('user_id', $userId)
        ->whereNull('deleted_at');

        $groups = DB::table('groups')
        ->selectRaw('groupings_date as date, id as group_id, name as group_name, `order` as group_order, members_id as member_id, members_name as member_name')
        ->leftJoinSub($groupings, 'groupings', function (JoinClause $join) {
            $join->on('groups.id', '=', 'groupings.groupings_group_id');
        })
        ->leftJoinSub($members, 'members', function (JoinClause $join) {
            $join->on('groupings.groupings_member_id', '=', 'members.members_id');
        })
        ->where('user_id', '=', $userId)
        ->whereNull('deleted_at')
        ->orderBy('group_order')
        ->get();

        $groupingData = [];
        $groupData = [];
        $memberData = [];
        $groupId = null;
        $groupName = null;

        foreach ($groups as $group) {
            if ($groupId === null && $groupName === null) {
                $groupId = $group->group_id;
                $groupName = $group->group_name;

                $memberData = [
                    'member_id' => $group->member_id,
                    'member_name' => $group->member_name,
                ];
                
                $groupData = [
                    'group_id' => $groupId,
                    'group_name' => $groupName,
                    'members' => [],
                ];

                array_push($groupData['members'], $memberData);
            }
            elseif ($groupId === $group->group_id && $groupName === $group->group_name) {
                $memberData = [
                    'member_id' => $group->member_id,
                    'member_name' => $group->member_name,
                ];

                array_push($groupData['members'], $memberData);
            }
            else {
                array_push($groupingData, $groupData);

                $groupId = $group->group_id;
                $groupName = $group->group_name;

                $memberData = [
                    'member_id' => $group->member_id,
                    'member_name' => $group->member_name,
                ];
                
                $groupData = [
                    'group_id' => $groupId,
                    'group_name' => $groupName,
                    'members' => [],
                ];

                array_push($groupData['members'], $memberData);
            }
        }

        array_push($groupingData, $groupData);

        return Inertia::render('Grouping/Index', [
            'groupings' => $groupingData,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, string $date)
    {
        $date = Carbon::today();
        $groupingData = GroupingService::getGroupingData($date);

        return Inertia::render('Grouping/Edit', [
            'groupings' => $groupingData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return abort(404);
    }

    public function past() {

    }
}
