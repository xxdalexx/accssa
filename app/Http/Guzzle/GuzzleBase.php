<?php

namespace App\Http\Guzzle;

use Illuminate\Support\Facades\Cache;

abstract class GuzzleBase
{
    protected $client;
    protected $params = [];
    protected $cacheName;
    protected $cacheTTL = 86400;
    protected $bustCache = false;

    protected function buildQuery(string $key, string $value)
    {
        $this->params['query'][$key] = $value;
    }

    protected function getResponse()
    {
        if ($this->bustCache) {
            Cache::forget($this->cacheName);
        }

        return Cache::remember($this->cacheName, $this->cacheTTL, function () {
            return json_decode(@$this->client->request('GET', '', $this->params)->getBody()->getContents());
        });
    }

    public function setCacheTTL($ttl)
    {
        $this->cacheTTL = $ttl;
        return $this;
    }

    public function bustCache()
    {
        $this->bustCache = true;
        return $this;
    }

}
