<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\GuzzleBase;
use App\Http\Guzzle\Sgp\Get\Results;
use App\Models\Site;

abstract class SgpApi extends GuzzleBase
{
    protected static array $directory = [
        'results' => Results::class
    ];

    public function __construct()
    {
        $this->params = [
            'headers' => [
                'Authorization' => 'Bearer ' . Site::sgpToken(),
                'Accept'        => 'application/json',
            ]
        ];
    }

    public static function __callStatic($name, $arguments)
    {
        if (array_key_exists($name, static::$directory)) {
            $class = static::$directory[$name];
            return (new $class(...$arguments))->get();
        }
    }

    abstract protected function setClient();

    abstract protected function setCacheKey();

    public function get()
    {
        $this->setClient();
        $this->setCacheKey();

        return $this->getResponse();
    }
}
