<?php


namespace App\SingleUseFeatures;

use App\Http\Guzzle\Sgp\SgpBase;

class AbandondedMembers
{
    public static function run()
    {
        $list = (new SgpBase)->getLeagueMemberList();
        $deleteList = [];

        foreach ($list->members as $userId => $member) {
            $response = (new SgpBase)->getDriverResults($userId);
            $eventCount = collect($response)->where('leagueId', 'ikG1uiyY6vvTGCTAL486M')->count();
            if ($eventCount == 0) {
                $deleteList[$userId] = $member->name;
            }
        }
        return $deleteList;
    }
}
