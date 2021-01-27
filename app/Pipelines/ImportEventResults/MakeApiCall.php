<?php

namespace App\Pipelines\ImportEventResults;

use App\Http\Guzzle\Sgp\SgpApi;

class MakeApiCall
{
    public function handle($dto, $next)
    {
        $dto->rawApiResult = SgpApi::results('0-s_Giz4-CyLbvvfJOm6L');

        return $next($dto);
    }
}
