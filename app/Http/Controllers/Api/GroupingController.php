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

        $members = Member::where('user_id', '=', $userId)->orderBy('kana')->get();

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
                'checkReceiveData'=> null,
                'checkGroupingMembers' =>null,
                'checkGroupingGroups' => null,
                'groupings' => null,
            ]);
        }

        $receiveData = $request->sendData;
        $groups = Group::where('user_id', '=', $userId)->get();
        $members = Member::where('user_id', '=', $userId)->get();

        foreach ($receiveData['groups'] as $receiveDataGroup) {
            if (!$groups->contains('id', intval($receiveDataGroup['group_id']))) {
                return response()->json([
                    'checkId'=> null,
                    'checkReceiveData'=> false,
                    'checkGroupingMembers' =>null,
                    'checkGroupingGroups' => null,
                    'groupings' => null,
                ]);
            }
        }

        foreach ($receiveData['members'] as $receiveDataMember) {
            if (!$members->contains('id', intval($receiveDataMember['member_id']))) {
                return response()->json([
                    'checkId'=> null,
                    'checkReceiveData'=> false,
                    'checkGroupingMembers' =>null,
                    'checkGroupingGroups' => null,
                    'groupings' => null,
                ]);
            }
        }

        // 受信データ加工
        $revReceiveDataMembers = [];
        foreach ($receiveData['members'] as $receiveDataMember) {
            array_push($revReceiveDataMembers, [
                'member_id' => intval($receiveDataMember['member_id']),
            ]);
        }

        $revReceiveDataGroups = [];
        foreach ($receiveData['groups'] as $receiveDataGroup) {
            if (intval($receiveDataGroup['group_number']) > 0) {
                array_push($revReceiveDataGroups, [
                    'group_id' => intval($receiveDataGroup['group_id']),
                    'group_number' => intval($receiveDataGroup['group_number'])
                ]);
            }
        }

        // 参照データ作成
        $maxDate = Carbon::today()->addDays(-1)->format('Y-m-d');
        $minDate = Carbon::today()->addDays(-30)->format('Y-m-d');

        $refData = [];
        foreach ($revReceiveDataMembers as $revReceiveDataMember) {
            $member = Member::findOrFail($revReceiveDataMember['member_id']);
            foreach($revReceiveDataGroups as $revReceiveDataGroup) {
                $group = $member->groups()->where('groups.id', '=', $revReceiveDataGroup['group_id'])->first();
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
        $allocatablesData = [];
        foreach ($revReceiveDataMembers as $revReceiveDataMember) {
            $member = Member::findOrFail($revReceiveDataMember['member_id']);
            
            $allocatableNum = $refData->where('member_id', '=', $member->id)->where('allocatable', '=', true)->count();

            array_push($allocatablesData, [
                'member_id' => $member->id,
                'allocatableNum' => $allocatableNum,
            ]);
        }

        // コレクションに加工
        $revReceiveDataMembers = collect($revReceiveDataMembers);
        $revReceiveDataGroups = collect($revReceiveDataGroups);
        $allocatablesData = collect($allocatablesData);

        // オブジェクトのコレクションに変換
        $refData = $refData->map(function ($item) {
            return (object) $item;
        });
        $revReceiveDataMembers = $revReceiveDataMembers->map(function ($item) {
            return (object) $item;
        });
        $revReceiveDataGroups = $revReceiveDataGroups->map(function ($item) {
            return (object) $item;
        });
        $allocatablesData = $allocatablesData->map(function ($item) {
            return (object) $item;
        });

        // 計算処理初期化
        $maxAllocatableNum = $allocatablesData->max('allocatableNum');
        $membersState = [];
        $groupsState = [];

        foreach ($revReceiveDataMembers as $revReceiveDataMember) {
            $member = Member::findOrFail($revReceiveDataMember->member_id);
            array_push($membersState, [
                'member_id' => $member->id,
                'group_id' => null,
                'isSet' => false,
            ]);
        }

        foreach ($revReceiveDataGroups as $revReceiveDataGroup) {
            $group = Group::findOrFail($revReceiveDataGroup->group_id);
            array_push($groupsState, [
                'group_id' => $group->id,
                'maxNumber' => $revReceiveDataGroup->group_number,
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
        for ($i = 0; $i <= $maxAllocatableNum; $i++) {
            $iAllocatables = $allocatablesData->filter(function ($allocatableData) use ($i) {
                return $allocatableData->allocatableNum == $i;
            });

            $iMembers = [];
            if (count($iAllocatables) != 0) {
                foreach($iAllocatables as $iAllocatable) {
                    $memberRefData = $refData->filter(function ($refDataItem) use ($iAllocatable) {
                        return ($refDataItem->member_id == $iAllocatable->member_id && $refDataItem->allocatable == true);
                    });
                    
                    if (count($memberRefData) == 0) {
                        $membersStateIndex = $membersState->search(function ($memberState) use ($iAllocatable) {
                            return $memberState->member_id == $iAllocatable->member_id;
                        });
                        
                        $membersState[$membersStateIndex]->group_id = null;
                        $membersState[$membersStateIndex]->isSet = true;
                        continue;
                    }
                    else {
                        foreach ($memberRefData as $memberRefDataItem) {
                            array_push($iMembers, $memberRefDataItem);
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

            if (count($iMembers) > 0) {
                // ここのアルゴリズムで計算結果が変わってくるので要検討
                //  priMemberId: member_id順でratioが最も小さいgroup_idに割り振っていく
                $calcType = 'priMemberId';

                if ($calcType == 'priMemberId') {
                    // $iMembersに含まれるmember_idを取得
                    $iMembersId = [];
                    foreach ($iMembers as $iMember) {
                        if (!in_array($iMember->member_id, $iMembersId)) {
                            array_push($iMembersId, $iMember->member_id);
                        }
                    }

                    // メンバー一人についてデータをまとめる
                    foreach ($iMembersId as $iMemberId) {
                        $iMemberData = [];
                        foreach ($iMembers as $iMember) {
                            if ($iMember->member_id === $iMemberId) {
                                array_push($iMemberData, $iMember);
                            }
                        }

                        // ratioを昇順に並び替え
                        usort($iMemberData, function($a, $b) {
                            return $a->ratio <=> $b->ratio; // 昇順
                        });

                        // コレクションに加工
                        $iMemberData = collect($iMemberData);
                        // オブジェクトのコレクションに変換
                        $iMemberData = $iMemberData->map(function ($item) {
                            return (object) $item;
                        });

                        foreach ($iMemberData as $iMemberDataItem) {
                            $iMemberDataItemMemberId = $iMemberDataItem->member_id;
                            $membersStateIndex = $membersState->search(function ($memberState) use ($iMemberDataItemMemberId) {
                                return $memberState->member_id == $iMemberDataItemMemberId;
                            });

                            if ($membersState[$membersStateIndex]->group_id !== null && $membersState[$membersStateIndex]->isSet === true) {
                                break;
                            }

                            $iMemberDataItemGroupId = $iMemberDataItem->group_id;
                            $groupsStateIndex = $groupsState->search(function ($groupState) use ($iMemberDataItemGroupId) {
                                return $groupState->group_id == $iMemberDataItemGroupId;
                            });
                            
                            if (($groupsState[$groupsStateIndex]->maxNumber > $groupsState[$groupsStateIndex]->setCounts) && $groupsState[$groupsStateIndex]->isSet === false) {
                                $membersState[$membersStateIndex]->group_id = $iMemberDataItemGroupId;
                                $membersState[$membersStateIndex]->isSet = true;

                                $groupsState[$groupsStateIndex]->setCounts += 1;
                                if($groupsState[$groupsStateIndex]->maxNumber === $groupsState[$groupsStateIndex]->setCounts) {
                                    $groupsState[$groupsStateIndex]->isSet = true;
                                }
                            }
                        }
                    }
                }
            }
        }

        // 送信データ加工
        $checkGroupingMembers = true;
        $checkGroupingGroups = true;

        foreach ($membersState as $memberState) {
            if (!$memberState->group_id) {
                $checkGroupingMembers = false;
                break;
            }
        }

        foreach ($groupsState as $groupState) {
            if (!$groupState->isSet) {
                $checkGroupingGroups = false;
                break;
            }
        }
        
        // 自力でgroup_id, member_idの順に並び替え
        $sendGroupingsData = [];

        $getOrderedGroups = Group::where('user_id', '=', $userId)->orderBy('order')->get();
        $getOrderedMembers = Member::where('user_id', '=', $userId)->orderBy('kana')->get();

        $orderedGroupId = [];
        foreach ($getOrderedGroups as $orderedGroup) {
            array_push($orderedGroupId, $orderedGroup->id);
        }
        array_push($orderedGroupId, null);

        $orderedMemberId = [];
        foreach ($getOrderedMembers as $orderedMember) {
            array_push($orderedMemberId, $orderedMember->id);
        }

        foreach ($orderedGroupId as $orderedGroupIdItem) {
            $sendGroupingData = [];
            $filteredMembersState = $membersState->filter(function ($memberState) use ($orderedGroupIdItem) {
                return ($memberState->group_id == $orderedGroupIdItem);
            });
            if (count($filteredMembersState) === 0) {
                $sendGroupingData = [
                    'group_id' => $orderedGroupIdItem,
                    'members' => [],
                ];
                array_push($sendGroupingsData, $sendGroupingData);
            }
            else {
                $sendGroupingMembersData = [];
                foreach ($orderedMemberId as $orderedMemberIdItem) {
                    $doubleFilteredMemberState = $filteredMembersState->filter(function ($filteredMemberState) use ($orderedMemberIdItem) {
                        return ($filteredMemberState->member_id == $orderedMemberIdItem);
                    });

                    if (count($doubleFilteredMemberState) == 1) {
                        $sendGroupingMemberData = [
                            'member_id' => $orderedMemberIdItem,
                        ];
                        array_push($sendGroupingMembersData, $sendGroupingMemberData);
                    }
                }
                $sendGroupingData = [
                    'group_id' => $orderedGroupIdItem,
                    'members' => $sendGroupingMembersData,
                ];
                
                array_push($sendGroupingsData, $sendGroupingData);
            }
        }

        return response()->json([
            'checkId'=> null,
            'checkReceiveData'=> null,
            'checkGroupingMembers' => $checkGroupingMembers,
            'checkGroupingGroups' => $checkGroupingGroups,
            'groupings' => $sendGroupingsData,
        ]);
    }
}
