<?php

namespace Tests;

use App\Models\Driver;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createMe()
    {
        $driver = $this->createMyDriver();

        $user = $driver->user()->create([
            'name' => 'Dale Carter',
            'email' => 'xthedalex@gmail.com',
            'password' => Hash::make('password'),
        ]);

        return [$driver, $user];
    }

    protected function createMyDriver()
    {
        return Driver::create([
            'driver_name' => 'Dale Carter',
            'sgp_id' => 'SXs33IH-ZDSa6A2hUzKU_',
            'discord_user_id' => '324060102770556933'
        ]);
    }
}
