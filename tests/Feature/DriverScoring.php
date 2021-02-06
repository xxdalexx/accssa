<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DriverScoring extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cant_be_a_duplicate_user_and_track_entry()
    {
        $this->assertTrue(true);
    }
}
