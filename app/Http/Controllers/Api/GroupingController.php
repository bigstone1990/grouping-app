<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\GroupingService;
use App\Models\Member;
use App\Models\Group;
use App\Models\Allocation;

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

    public function getAutoGroupings(Request $request)
    {
        // チェック処理
        $userId = Auth::id();

        if (intval($request->userId) !== $userId) {
            return response()->json([
                'checkId'=> false,
                'checkSendData'=> null,
                'groupings' => null,
            ]);
        }

        $sendData = $request->sendData;
        $groups = Group::where('user_id', '=', $userId)->get();
        $members = Member::where('user_id', '=', $userId)->get();

        foreach ($sendData['groups'] as $sendGroup) {
            if (!$groups->contains('id', intval($sendGroup['group_id']))) {
                return response()->json([
                    'checkId'=> null,
                    'checkSendData'=> false,
                    'groupings' => null,
                ]);
            }
        }

        foreach ($sendData['members'] as $sendMember) {
            if (!$members->contains('id', intval($sendMember['member_id']))) {
                return response()->json([
                    'checkId'=> null,
                    'checkSendData'=> false,
                    'groupings' => null,
                ]);
            }
        }

        // 受信データ加工
        $revSendMembers = [];
        foreach ($sendData['members'] as $sendMember) {
            array_push($revSendMembers, [
                'member_id' => intval($sendMember['member_id']),
            ]);
        }

        $revSendGroups = [];
        foreach ($sendData['groups'] as $sendGroup) {
            if (intval($sendGroup['group_number']) > 0) {
                array_push($revSendGroups, [
                    'group_id' => intval($sendGroup['group_id']),
                    'group_number' => intval($sendGroup['group_number'])
                ]);
            }
        }

        // 参照データ作成
        $maxDate = Carbon::today()->addDays(-1)->format('Y-m-d');
        $minDate = Carbon::today()->addDays(-30)->format('Y-m-d');

        $refData = [];
        foreach ($revSendMembers as $revSendMember) {
            $member = Member::findOrFail($revSendMember['member_id']);
            foreach($revSendGroups as $revSendGroup) {
                $group = $member->groups()->where('groups.id', '=', $revSendGroup['group_id'])->first();
                if(!is_null($group)) {
                    $total = DB::table('groupings')
                    ->where('user_id', '=', $userId)
                    ->where('member_id', '=', $member->id)
                    ->whereBetween('date', [$minDate, $maxDate])
                    ->whereNull('deleted_at')
                    ->count();

                    $subTotal = DB::table('groupings')
                    ->where('user_id', '=', $userId)
                    ->where('group_id', '=', $group->id)
                    ->where('member_id', '=', $member->id)
                    ->whereBetween('date', [$minDate, $maxDate])
                    ->whereNull('deleted_at')
                    ->count();

                    $ratio = 0.00000;
                    if ($total !== 0) {
                        $ratio = round($subTotal / $total, 5);
                    }

                    array_push($refData, [
                        'member_id' => $member->id,
                        'group_id' => $group->id,
                        'allocatable' => $group->pivot->allocatable,
                        'ratio' => $ratio,
                    ]);
                }
            }
        }

        // コレクションに加工
        $refData = collect($refData);

        // allocatable == true の個数を計算
        $allocatables = [];
        foreach ($revSendMembers as $revSendMember) {
            $member = Member::findOrFail($revSendMember['member_id']);
            
            $count = $refData->where('member_id', '=', $member->id)->where('allocatable', '=', true)->count();

            array_push($allocatables, [
                'member_id' => $member->id,
                'allocatables' => $count,
            ]);
        }

        // コレクションに加工
        $revSendMembers = collect($revSendMembers);
        $revSendGroups = collect($revSendGroups);
        $allocatables = collect($allocatables);

        // オブジェクトのコレクションに変換
        $refData = $refData->map(function ($item) {
            return (object) $item;
        });
        $revSendMembers = $revSendMembers->map(function ($item) {
            return (object) $item;
        });
        $revSendGroups = $revSendGroups->map(function ($item) {
            return (object) $item;
        });
        $allocatables = $allocatables->map(function ($item) {
            return (object) $item;
        });

        // 計算処理初期化
        $maxAllocatables = $allocatables->max('allocatables');
        $membersState = [];
        $groupsState = [];

        foreach ($revSendMembers as $revSendMember) {
            $member = Member::findOrFail($revSendMember->member_id);
            array_push($membersState, [
                'member_id' => $member->id,
                'group_id' => null,
                'isSet' => false,
            ]);
        }

        foreach ($revSendGroups as $revSendGroup) {
            $group = Group::findOrFail($revSendGroup->group_id);
            array_push($groupsState, [
                'group_id' => $group->id,
                'setCounts' => 0,
                'isSet' => false,
            ]);
        }

        // コレクションに加工
        $membersState = collect($membersState);
        $groupsState = collect($groupsState);

        // オブジェクトのコレクションに変換
        $membersState = $membersState->map(function ($item) {
            return (object) $item;
        });
        $groupsState = $groupsState->map(function ($item) {
            return (object) $item;
        });

        // デバッグ用
        $debugData = [];

        // 計算処理本処理
        for ($i = 0; $i <= $maxAllocatables; $i++) {
            $iAllocatables = $allocatables->filter(function ($allocatable) use ($i) {
                return $allocatable->allocatables == $i;
            });

            $iMembers = [];
            if (count($iAllocatables) != 0) {
                foreach($iAllocatables as $iAllocatable) {
                    $memberRefData = $refData->filter(function ($ref) use ($iAllocatable) {
                        return ($ref->member_id == $iAllocatable->member_id && $ref->allocatable == true);
                    });
                    
                    if (count($memberRefData) == 0) {
                        $index = $membersState->search(function ($member) use ($iAllocatable) {
                            return $member->member_id == $iAllocatable->member_id;
                        });
                        
                        $membersState[$index]->group_id = null;
                        $membersState[$index]->isSet = true;
                        continue;
                    }
                    else {
                        foreach ($memberRefData as $member) {
                            array_push($iMembers, $member);
                        }
                    }
                }
            }
            // $iMemberを使って、たとえば、allocatableが1のデータのmemberのそれぞれのgroupのratioを比較する
            // コレクションに加工
            $iMembers = collect($iMembers);
            // オブジェクトのコレクションに変換
            $iMembers = $iMembers->map(function ($item) {
                return (object) $item;
            });
            // foreach ($iMembers as $iMember) {
            //     array_push($debugData, $iMember);
            // };
            // array_push($debugData, $i);
        }

        // 送信データ加工

        return response()->json([
            'checkId'=> null,
            'checkSendData'=> null,
            'groupings' => $debugData,
        ]);
    }
}
