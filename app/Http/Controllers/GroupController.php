<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Http\Request;
use App\Models\Group;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $maxOrder = Group::where('user_id', '=', Auth::id())->max('order');
        $newOrder = $maxOrder + 1;

        Group::create([
            'user_id' => Auth::id(),
            'name' => $request->groupName,
            'order' => $newOrder,
        ]);

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
        return Inertia::render('Group/Edit', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
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
        $group->delete();


        $groups = Group::where('user_id', '=', Auth::id())->orderBy('order')->get();
        for ($i = 0; $i < count($groups); $i++) {
            $groups[$i]->order = $i + 1;
            $groups[$i]->save();
        }

        return to_route('groups.index')->with([
            'message' => '削除しました',
            'status' => 'danger',
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

        return to_route('groups.index')->with([
            'message' => '更新しました',
            'status' => 'success',
        ]);
    }
}
