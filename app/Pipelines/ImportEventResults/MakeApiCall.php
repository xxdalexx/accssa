<?php

namespace App\Pipelines\ImportEventResults;

use App\Http\Guzzle\Sgp\SgpApi;

class MakeApiCall
{
    public function handle(DTO $dto, $next)
    {
        $rawApiResult = SgpApi::eventResults($dto->getEventId());

        $dto->results = SgpACCApiResult::load($rawApiResult);

        return $next($dto);
    }
}
