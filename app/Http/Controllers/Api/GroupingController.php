<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\GroupingService;

class GroupingController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $maxDate = Carbon::today()->addDays(-1)->format('Y-m-d');
        $minDate = Carbon::today()->addDays(-7)->format('Y-m-d');

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

        $groupingData = GroupingService::getGroupingData($request->date);

        return response()->json([
            'checkId'=> null,
            'checkDate'=> null,
            'groupings' => $groupingData,
        ]);

    }
}
