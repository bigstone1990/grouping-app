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

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $membersData = [];
        
        $members = Member::where('user_id', '=', Auth::id())->orderBy('id')->get();
        
        foreach ($members as $member) {
            $groupsData = [];

            $groups = $member->groups()->orderBy('order')->get();

            foreach ($groups as $group) {
                $groupData = [
                    'group_id' => $group->id,
                    'group_name' => $group->name,
                    'group_order' => $group->order,
                    'allocatable' => $group->pivot->allocatable,
                ];

                array_push($groupsData, $groupData);
            }

            $memberData = [
                'member_id' => $member->id,
                'member_name' => $member->name,
                'groups_data' => $groupsData,
            ];

            array_push($membersData, $memberData);
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
        $groups = Group::where('user_id', '=', Auth::id())->orderBy('order')->get();

        return Inertia::render('Member/Create', [
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $member = Member::create([
            'user_id' => Auth::id(),
            'name' => $request->memberName,
        ]);

        foreach ($request->groupAllocatable as $group) {
            Allocation::create([
                'member_id' => $member->id,
                'group_id' => $group['group_id'],
                'allocatable' => $group['group_allocatable'],
            ]);
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
        if ($member->user_id !== Auth::id()) {
            return abort(404);
        }

        $groupsData = [];

        $groups = $member->groups()->orderBy('order')->get();

        foreach ($groups as $group) {
            $groupData = [
                'group_id' => $group->id,
                'group_name' => $group->name,
                'group_order' => $group->order,
                'allocatable' => $group->pivot->allocatable,
            ];

            array_push($groupsData, $groupData);
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
        if ($member->user_id !== Auth::id()) {
            return abort(404);
        }

        $member->name = $request->memberName;

        $member->save();

        foreach ($request->groupAllocatable as $group) {
            $allocation = Allocation::where('member_id', '=', $member->id)->where('group_id', '=', $group['group_id'])->first();
            $allocation->allocatable = $group['group_allocatable'];
            $allocation->save();
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
        if ($member->user_id !== Auth::id()) {
            abort(404);
        }

        $allocations = Allocation::where('member_id', '=', $member->id)->get();

        foreach ($allocations as $allocation) {
            $allocation->delete();
        }

        $member->delete();

        return to_route('members.index')->with([
            'message' => '削除しました',
            'status' => 'danger',
        ]);
    }
}
