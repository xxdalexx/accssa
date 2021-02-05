<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\GuzzleBase;
use App\Http\Guzzle\Sgp\Get\DriverResults;
use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\EventResults;
use App\Models\Site;
use BadMethodCallException;

/**
 * @method static memberList(?string $leagueId)
 * @method static leagueViews(string|null $leagueId)
 * @method static eventResults(string $eventId)
 * @method static driverResults(string $eventId)
 */
abstract class SgpApi extends GuzzleBase
{
    protected static array $directory = [
        'eventResults' => EventResults::class,
        'leagueViews' => LeagueViews::class,
        'memberList' => LeagueViews::class, //alias
        'driverResults' => DriverResults::class,
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

        throw new BadMethodCallException;
    }

    abstract protected function setClient(): self;

    abstract protected function setCacheKey(): self;

    public function get()
    {
        $this->setClient();
        $this->setCacheKey();

        return $this->getResponse();
    }
}
