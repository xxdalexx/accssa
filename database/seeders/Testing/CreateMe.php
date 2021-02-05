<?php

namespace Database\Seeders\Testing;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateMe extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $driver = Driver::create([
            'driver_name' => 'Dale Carter',
            'sgp_id' => 'SXs33IH-ZDSa6A2hUzKU_',
            'discord_user_id' => '324060102770556933'
        ]);

        $user = $driver->user()->create([
            'name' => 'Dale Carter',
            'email' => 'xthedalex@gmail.com',
            'password' => Hash::make('password'),
        ]);

    }
}
