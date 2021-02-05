<?php


namespace App\Http\Guzzle\Sgp\Get\Responses;


use App\Http\Guzzle\Sgp\SgpApi;

class LeagueViewsResponse
{
    protected $rawResponse;

    public function __construct(SgpApi $caller)
    {
        $this->rawResponse = $caller->get();
    }

    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    public function memberList()
    {
        return collect($this->rawResponse->members);
    }

    public function findMemberByDiscordId(string $discordUserId)
    {
        return $this->memberList()->firstWhere('discord.id', $discordUserId);
    }
}
