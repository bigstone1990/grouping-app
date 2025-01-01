<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Jobs\SendUserCreatedMail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return Inertia::render('User/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $password = Str::random(8);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => intval($request->role),
        ]);

        SendUserCreatedMail::dispatch($user, $password);

        return to_route('users.index')->with([
            'message' => '登録しました',
            'status' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $modifiable = true;
        $deletable = true;
        if ($user->id === Auth::id()) {
            $deletable = false;
            if ($user->role === 1) {
                $modifiable = false;
            }
        }

        return Inertia::render('User/Edit', [
            'user' => $user,
            'modifiable' => $modifiable,
            'deletable' => $deletable,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($user->id === Auth::id()) {
            if ($user->role === 1) {
                return abort(404);
            }
        }

        $user->role = intval($request->role);

        $user->save();

        return to_route('users.index')->with([
            'message' => '更新しました',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return abort(404);
        }

        $user->delete();

        return to_route('users.index')->with([
            'message' => '削除しました',
            'status' => 'success',
        ]);
    }
}
