<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Member;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Allocation;
use App\Models\Grouping;
use Carbon\Carbon;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $membersData = [];
        
        $members = Member::where('user_id', '=', $userId)->orderBy('id')->get();
        
        if (!$members->isEmpty()) {
            foreach ($members as $member) {
                $groupsData = [];
    
                $groups = $member->groups()->orderBy('order')->get();
    
                if (!$groups->isEmpty()) {
                    // user_id チェック
                    foreach ($groups as $group) {
                        $groupTmp = Group::findOrFail($group->id);

                        if ($groupTmp->user_id !== $userId) {
                            return abort(404);
                        }
                    }

                    foreach ($groups as $group) {
                        $groupData = [
                            'group_id' => $group->id,
                            'group_name' => $group->name,
                            'group_order' => $group->order,
                            'allocatable' => $group->pivot->allocatable,
                        ];
        
                        array_push($groupsData, $groupData);
                    }
                }
    
                $memberData = [
                    'member_id' => $member->id,
                    'member_name' => $member->name,
                    'groups_data' => $groupsData,
                ];
    
                array_push($membersData, $memberData);
            }
        }

        return Inertia::render('Member/Index', [
            'members' => $membersData,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = Auth::id();

        $groups = Group::where('user_id', '=', $userId)->orderBy('order')->get();

        return Inertia::render('Member/Create', [
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $userId = Auth::id();

        // user_id チェック
        if (!empty($request->groupAllocatable)) {
            foreach ($request->groupAllocatable as $group) {
                $groupTmp = Group::findOrFail($group['group_id']);

                if ($groupTmp->user_id !== $userId) {
                    return abort(404);
                }
            }
        }

        $member = Member::create([
            'user_id' => $userId,
            'name' => $request->memberName,
        ]);

        if (!empty($request->groupAllocatable)) {
            foreach ($request->groupAllocatable as $group) {
                Allocation::create([
                    'member_id' => $member->id,
                    'group_id' => $group['group_id'],
                    'allocatable' => $group['group_allocatable'],
                ]);
            }
        }

        return to_route('members.index')->with([
            'message' => '登録しました',
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $userId = Auth::id();

        if ($member->user_id !== $userId) {
            return abort(404);
        }

        $groupsData = [];

        $groups = $member->groups()->orderBy('order')->get();

        if (!$groups->isEmpty()) {
            // user_id チェック
            foreach ($groups as $group) {
                $groupTmp = Group::findOrFail($group->id);

                if ($groupTmp->user_id !== $userId) {
                    return abort(404);
                }
            }

            foreach ($groups as $group) {
                $groupData = [
                    'group_id' => $group->id,
                    'group_name' => $group->name,
                    'group_order' => $group->order,
                    'allocatable' => $group->pivot->allocatable,
                ];
    
                array_push($groupsData, $groupData);
            }
        }

        $memberData = [
            'member_id' => $member->id,
            'member_name' => $member->name,
            'groups_data' => $groupsData,
        ];

        return Inertia::render('Member/Edit', [
            'member' => $memberData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $userId = Auth::id();

        if ($member->user_id !== $userId) {
            return abort(404);
        }

        // user_id チェック
        if (!empty($request->groupAllocatable)) {
            foreach ($request->groupAllocatable as $group) {
                $groupTmp = Group::findOrFail($group['group_id']);
                if ($groupTmp->user_id !== $userId) {
                    return abort(404);
                }
            }
        }

        $member->name = $request->memberName;

        $member->save();

        if (!empty($request->groupAllocatable)) {
            foreach ($request->groupAllocatable as $group) {
                $allocation = Allocation::where('member_id', '=', $member->id)->where('group_id', '=', $group['group_id'])->first();

                if (!is_null($allocation)) {
                    $allocation->allocatable = $group['group_allocatable'];
                    $allocation->save();
                }
            }
        }

        return to_route('members.index')->with([
            'message' => '更新しました',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $userId = Auth::id();

        if ($member->user_id !== $userId) {
            abort(404);
        }

        $allocations = Allocation::where('member_id', '=', $member->id)->get();

        if (!$allocations->isEmpty()) {
            foreach ($allocations as $allocation) {
                $allocation->delete();
            }
        }

        $date = Carbon::today();
        $grouping = Grouping::where('date', '=', $date)->where('user_id', '=', $userId)->where('member_id', '=', $member->id)->first();

        if (!is_null($grouping)) {
            $grouping->delete();
        }

        $member->delete();

        return to_route('members.index')->with([
            'message' => '削除しました',
            'status' => 'success',
        ]);
    }

    public function calcGroupings()
    {
        $memberData = null;

        return Inertia::render('Member/CalcGroupings', [
            'member' => $memberData,
        ]);
    }
}
