<?php

namespace App\Pipelines\ProcessDiscordRegistration;

use App\Models\Driver;

class CheckForDriverRecord
{
    public function handle(DTO $dto, $next)
    {
        if ($driver = Driver::whereDiscordUserId($dto->discordUserInfo->id)->first()) {
            $dto->returnRouteName = 'home'; //go to registration page.
            return $dto;
        }

        return $next($dto);
    }
}
