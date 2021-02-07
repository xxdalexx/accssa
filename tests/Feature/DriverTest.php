<?php


use App\Models\Driver;
use Tests\TestCase;

class DriverTest extends TestCase
{
    /** @test */
    public function discord_private_message_id_auto_populates_when_discord_user_id_is_set()
    {
        $driver = Driver::make([
            'driver_name' => 'Dale Carter',
            'sgp_id' => 'SXs33IH-ZDSa6A2hUzKU_',
        ]);

        $this->assertNull($driver->discord_private_channel_id);

        $driver->discord_user_id = '324060102770556933';

        $this->assertNotNull($driver->discord_private_channel_id);
    }
}
