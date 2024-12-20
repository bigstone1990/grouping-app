<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Member;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupingController extends Controller
{
    public function index() {
        $members = Member::where('user_id', '=', Auth::id())->orderBy('id')->get();
        $groups = Group::where('user_id', '=', Auth::id())->orderBy('id')->get();

        return Inertia::render('Grouping/Index', [
            'members' => $members,
            'groups' => $groups,
        ]);
    }
}
