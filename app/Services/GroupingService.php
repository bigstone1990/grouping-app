<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class GroupingService
{
    public static function getGroupingData($date)
    {
        $userId = Auth::id();
        
        $groups = DB::table('groups')
        ->selectRaw('id, name as group_name, `order` as group_order')
        ->where('user_id', '=', $userId)
        ->whereNull('deleted_at');

        $members = DB::table('members')
        ->selectRaw('id, name as member_name')
        ->where('user_id', '=', $userId)
        ->whereNull('deleted_at');

        $groupings = DB::table('groupings')
        ->selectRaw('groupings.id, groupings.date, groupings.group_id, groups.group_name, groups.group_order, groupings.member_id, members.member_name')
        ->leftJoinSub($groups, 'groups', function (JoinClause $join) {
            $join->on('groupings.group_id', '=', 'groups.id');
        })
        ->leftJoinSub($members, 'members', function (JoinClause $join) {
            $join->on('groupings.member_id', '=', 'members.id');
        })
        ->where('groupings.date', $date)
        ->where('groupings.user_id', $userId)
        ->whereNull('groupings.deleted_at')
        ->orderBy('groups.group_order')
        ->orderBy('groupings.member_id')
        ->get();

        $groupingData = [];
        $groupData = [];
        $memberData = [];
        $groupId = null;
        $groupName = null;

        foreach ($groupings as $grouping) {
            if (is_null($groupId) && is_null($groupName)) {
                $groupId = $grouping->group_id;
                $groupName = $grouping->group_name;

                $groupData = [
                    'group_id' => $groupId,
                    'group_name' => $groupName,
                    'members' => [],
                ];

                if (!is_null($grouping->member_id) && !is_null($grouping->member_name)) {
                    $memberData = [
                        'member_id' => $grouping->member_id,
                        'member_name' => $grouping->member_name,
                    ];

                    array_push($groupData['members'], $memberData);
                }

            }
            elseif ($groupId === $grouping->group_id && $groupName === $grouping->group_name) {
                if (!is_null($grouping->member_id) && !is_null($grouping->member_name)) {
                    $memberData = [
                        'member_id' => $grouping->member_id,
                        'member_name' => $grouping->member_name,
                    ];

                    array_push($groupData['members'], $memberData);
                }
            }
            else {
                array_push($groupingData, $groupData);

                $groupId = $grouping->group_id;
                $groupName = $grouping->group_name;

                $groupData = [
                    'group_id' => $groupId,
                    'group_name' => $groupName,
                    'members' => [],
                ];

                if (!is_null($grouping->member_id) && !is_null($grouping->member_name)) {
                    $memberData = [
                        'member_id' => $grouping->member_id,
                        'member_name' => $grouping->member_name,
                    ];

                    array_push($groupData['members'], $memberData);
                }
            }
        }

        if (!empty($groupData)) {
            array_push($groupingData, $groupData);
        }

        return $groupingData;
    }

    public static function getGroupingPastData($date)
    {
        $userId = Auth::id();
        
        $groups = DB::table('groups')
        ->selectRaw('id, name as group_name, `order` as group_order')
        ->where('user_id', '=', $userId);

        $members = DB::table('members')
        ->selectRaw('id, name as member_name')
        ->where('user_id', '=', $userId);

        $groupings = DB::table('groupings')
        ->selectRaw('groupings.id, groupings.date, groupings.group_id, groups.group_name, groups.group_order, groupings.member_id, members.member_name')
        ->leftJoinSub($groups, 'groups', function (JoinClause $join) {
            $join->on('groupings.group_id', '=', 'groups.id');
        })
        ->leftJoinSub($members, 'members', function (JoinClause $join) {
            $join->on('groupings.member_id', '=', 'members.id');
        })
        ->where('groupings.date', $date)
        ->where('groupings.user_id', $userId)
        ->whereNull('groupings.deleted_at')
        ->orderBy('groups.group_order')
        ->orderBy('groupings.member_id')
        ->get();

        $groupingData = [];
        $groupData = [];
        $memberData = [];
        $groupId = null;
        $groupName = null;

        foreach ($groupings as $grouping) {
            if (is_null($groupId) && is_null($groupName)) {
                $groupId = $grouping->group_id;
                $groupName = $grouping->group_name;

                $groupData = [
                    'group_id' => $groupId,
                    'group_name' => $groupName,
                    'members' => [],
                ];

                if (!is_null($grouping->member_id) && !is_null($grouping->member_name)) {
                    $memberData = [
                        'member_id' => $grouping->member_id,
                        'member_name' => $grouping->member_name,
                    ];

                    array_push($groupData['members'], $memberData);
                }

            }
            elseif ($groupId === $grouping->group_id && $groupName === $grouping->group_name) {
                if (!is_null($grouping->member_id) && !is_null($grouping->member_name)) {
                    $memberData = [
                        'member_id' => $grouping->member_id,
                        'member_name' => $grouping->member_name,
                    ];

                    array_push($groupData['members'], $memberData);
                }
            }
            else {
                array_push($groupingData, $groupData);

                $groupId = $grouping->group_id;
                $groupName = $grouping->group_name;

                $groupData = [
                    'group_id' => $groupId,
                    'group_name' => $groupName,
                    'members' => [],
                ];

                if (!is_null($grouping->member_id) && !is_null($grouping->member_name)) {
                    $memberData = [
                        'member_id' => $grouping->member_id,
                        'member_name' => $grouping->member_name,
                    ];

                    array_push($groupData['members'], $memberData);
                }
            }
        }

        if (!empty($groupData)) {
            array_push($groupingData, $groupData);
        }

        return $groupingData;
    }

    public static function getEmptyGroupingData()
    {
        $userId = Auth::id();

        $groups = Group::where('user_id', '=', $userId)->orderBy('order')->get();

        $groupingData = [];

        foreach ($groups as $group) {
            $groupId = $group->id;
            $groupName = $group->name;

            $groupData = [
                'group_id' => $groupId,
                'group_name' => $groupName,
                'members' => [],
            ];

            array_push($groupingData, $groupData);
        }

        return $groupingData;
    }
}