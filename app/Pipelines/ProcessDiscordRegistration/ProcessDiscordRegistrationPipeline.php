<?php

namespace App\Pipelines\ProcessDiscordRegistration;

class ProcessDiscordRegistrationPipeline
{
    protected static array $pipes = [
        CheckForDriverRecord::class,
        AttemptToFindDriverInSGPMemberList::class,
    ];

    public static function run($discordUserResponse)
    {
        $passable = new DTO($discordUserResponse);

        $finalDTO = app('Illuminate\Pipeline\Pipeline')
            ->send($passable)
            ->through(static::$pipes)
            ->thenReturn();

        return $finalDTO->returnRouteName;
    }
}
