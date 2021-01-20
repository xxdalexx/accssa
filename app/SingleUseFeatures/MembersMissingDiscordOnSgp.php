<?php

namespace App\SingleUseFeatures;

use App\Http\Guzzle\Sgp\SgpBase;

class MembersMissingDiscordOnSgp
{
    public static function run()
    {
        $missing = [];
        $members = (new SgpBase)->getLeagueMemberList()->members;

        foreach ($members as $member) {
            if (property_exists($member, 'discord')) continue;
            $missing[$member->name] = $member->userId;
        }
        ksort($missing);
        ddd($missing);
    }
}
