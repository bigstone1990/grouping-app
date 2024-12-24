<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;
use App\Models\Member;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
