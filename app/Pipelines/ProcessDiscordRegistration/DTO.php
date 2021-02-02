<?php

namespace App\Pipelines\ProcessDiscordRegistration;

class DTO
{
    public $discordUserInfo;

    public $returnRouteName = 'home';

    public function __construct($discordUserInfo)
    {
        $this->discordUserInfo = $discordUserInfo;
    }

}
