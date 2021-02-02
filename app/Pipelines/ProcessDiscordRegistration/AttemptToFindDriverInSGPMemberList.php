<?php

namespace App\Pipelines\ProcessDiscordRegistration;

class AttemptToFindDriverInSGPMemberList
{
    public function handle(DTO $dto, $next)
    {

        return $next($dto);
    }
}
