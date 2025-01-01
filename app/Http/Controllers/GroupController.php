<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Http\Request;
use App\Models\Group;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Allocation;
use App\Models\Grouping;
use Carbon\Carbon;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::where('user_id', '=', Auth::id())->orderBy('order')->get();
        return Inertia::render('Group/Index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Group/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $userId = Auth::id();

        $newOrder = 1;
        $maxOrder = Group::where('user_id', '=', $userId)->max('order');

        if (!is_null($maxOrder)) {
            $newOrder = $maxOrder + 1;
        }

        $group = Group::create([
            'user_id' => $userId,
            'name' => $request->groupName,
            'order' => $newOrder,
        ]);

        $members = Member::where('user_id', '=', $userId)->orderBy('id')->get();

        if (!$members->isEmpty()) {
            foreach ($members as $member) {
                Allocation::create([
                    'member_id' => $member->id,
                    'group_id' => $group->id,
                    'allocatable' => true,
                ]);
            }
        }

        $date = Carbon::today();
        $groupings = Grouping::where('date', '=', $date)->where('user_id', '=', $userId)->get();

        if (!$groupings->isEmpty()) {
            Grouping::create([
                'date' => $date,
                'user_id' => $userId,
                'member_id' => null,
                'group_id' => $group->id,
            ]);
        }

        return to_route('groups.index')->with([
            'message' => '登録しました',
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        if ($group->user_id !== Auth::id()) {
            return abort(404);
        }

        return Inertia::render('Group/Edit', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        if ($group->user_id !== Auth::id()) {
            return abort(404);
        }

        $group->name = $request->groupName;

        $group->save();

        return to_route('groups.index')->with([
            'message' => '更新しました',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $userId = Auth::id();

        if ($group->user_id !== $userId) {
            abort(404);
        }

        $allocations = Allocation::where('group_id', '=', $group->id)->get();

        if (!$allocations->isEmpty()) {
            foreach ($allocations as $allocation) {
                $allocation->delete();
            }
        }

        $date = Carbon::today();
        $groupings = Grouping::where('date', '=', $date)->where('user_id', '=', $userId)->where('group_id', '=', $group->id)->get();

        if (!$groupings->isEmpty()) {
            foreach ($groupings as $grouping) {
                $grouping->delete();
            }
        }

        $group->delete();

        $groups = Group::where('user_id', '=', Auth::id())->orderBy('order')->get();

        if (!$groups->isEmpty()) {
            for ($i = 0; $i < count($groups); $i++) {
                $groups[$i]->order = $i + 1;
                $groups[$i]->save();
            }
        }

        return to_route('groups.index')->with([
            'message' => '削除しました',
            'status' => 'success',
        ]);
    }

    public function orderingEdit()
    {
        $groups = Group::where('user_id', '=', Auth::id())->orderBy('order')->get();
        return Inertia::render('Group/Order', [
            'groups' => $groups,
        ]);
    }

    public function orderingUpdate(Request $request)
    {
        if (!empty($request->orderData)) {
            foreach ($request->orderData as $data) {
                $groupId = $data['id'];
                $groupOrder = $data['order'];
                
                $group = Group::findOrFail($groupId);
    
                if ($group->user_id !== Auth::id()) {
                    return abort(404);
                }
                
                $group->order = $groupOrder;
                $group->save();
            }
        }

        return to_route('groups.index')->with([
            'message' => '更新しました',
            'status' => 'success',
        ]);
    }
}
