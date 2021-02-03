<?php

namespace App\Http\Guzzle\Sgp;

use App\Http\Guzzle\GuzzleBase;
use App\Http\Guzzle\Sgp\Get\LeagueViews;
use App\Http\Guzzle\Sgp\Get\Results;
use App\Models\Site;
use BadMethodCallException;
use phpDocumentor\Reflection\Types\Nullable;

/**
 * @method static memberList(?string $leagueId)
 * @method static leagueViews(string|null $leagueId)
 * @method static results(string $eventId)
 */
abstract class SgpApi extends GuzzleBase
{
    protected static array $directory = [
        'results' => Results::class,
        'leagueViews' => LeagueViews::class,
        'memberList' => LeagueViews::class, //alias
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
