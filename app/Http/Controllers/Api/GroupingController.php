<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\GroupingService;
use App\Models\Member;

class GroupingController extends Controller
{
    public function getPastGroupings(Request $request)
    {
        $userId = Auth::id();
        $maxDate = Carbon::today()->addDays(-1)->format('Y-m-d');
        $minDate = Carbon::today()->addDays(-30)->format('Y-m-d');

        if (intval($request->userId) !== $userId) {
            return response()->json([
                'checkId'=> false,
                'checkDate'=> null,
                'groupings' => null,
            ]);
        }

        if ($request->date < $minDate || $request->date > $maxDate) {
            return response()->json([
                'checkId'=> null,
                'checkDate'=> false,
                'groupings' => null,
            ]);
        }

        $groupingData = GroupingService::getGroupingPastData($request->date);

        return response()->json([
            'checkId'=> null,
            'checkDate'=> null,
            'groupings' => $groupingData,
        ]);
    }

    public function getAllMembers(Request $request)
    {
        $userId = Auth::id();

        if (intval($request->userId) !== $userId) {
            return response()->json([
                'checkId'=> false,
                'members' => null,
            ]);
        }

        $members = Member::where('user_id', '=', $userId)->orderBy('id')->get();

        return response()->json([
            'checkId'=> null,
            'checkDate'=> null,
            'members' => $members,
        ]);
    }
}
