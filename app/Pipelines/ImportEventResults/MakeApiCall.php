<?php

namespace App\Pipelines\ImportEventResults;

use App\Http\Guzzle\Sgp\SgpApi;

class MakeApiCall
{
    public function handle(DTO $dto, $next)
    {
        $rawApiResult = SgpApi::results('0-s_Giz4-CyLbvvfJOm6L');

        $dto->results = SgpACCApiResult::load($rawApiResult);

        return $next($dto);
    }
}
