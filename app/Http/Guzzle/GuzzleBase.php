<?php

namespace App\Http\Guzzle;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

abstract class GuzzleBase
{
    protected \GuzzleHttp\Client $client;
    protected $params = [];
    protected $cacheName;
    protected $cacheTTL = 86400;
    protected $bustCache = false;
    protected $cacheResponse = true;

    protected function buildQuery(string $key, string $value)
    {
        $this->params['query'][$key] = $value;
    }

    protected function getResponse($method = 'GET')
    {
        //Make call and return response if caching is disabled or there is no cache name set.
        if (!isset($this->cacheName) || !$this->cacheResponse) {
            return $this->makeCall($method);
        }

        if ($this->bustCache) {
            Cache::forget($this->cacheName);
        }

        $call = $this->makeCall($method);
        if (isset($call->message) && $call->message == 'Unauthorized') {
            User::first()->sendDiscordDM('SGP Token Needs Updated.');
            return false;
        }

        return Cache::remember($this->cacheName, $oneDay = $this->cacheTTL, function () use ($call) {
            return $call;
        });
    }

    protected function makeCall($method = 'GET')
    {
        $this->params['http_errors'] = false;
        return json_decode(@$this->client->request($method, '', $this->params)->getBody()->getContents());
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

    public function dontCache()
    {
        $this->cacheResponse = false;
        return $this;
    }

}
