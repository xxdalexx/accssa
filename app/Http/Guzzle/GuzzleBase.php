<?php

namespace App\Http\Guzzle;

abstract class GuzzleBase
{
    protected $client;
    protected $params = [];

    protected function buildQuery(string $key, string $value)
    {
        $this->params['query'][$key] = $value;
    }

    protected function getResponse()
    {
        return json_decode(@$this->client->request('GET', '', $this->params)->getBody()->getContents());
    }

}
