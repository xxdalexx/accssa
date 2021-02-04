<?php

namespace App\Pipelines\ProcessDiscordRegistration;

use App\Http\Guzzle\Sgp\SgpApi;
use App\Models\Driver;

class AttemptToFindDriverInSGPMemberList
{
    public function handle(DTO $dto, $next)
    {
        $memberList = collect(SgpApi::memberList()->members);

        $member = $memberList->firstWhere('discord.id', '324060102770556933');

        if ($member) {
            return $next($dto);
        } else {

        }
    }
}
