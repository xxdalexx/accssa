<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EventEntry;

class EventEntryFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = EventEntry::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'driver_id' => \App\Models\Driver::factory(),
            'event_id' => \App\Models\Event::factory(),
            'server_car_id' => $this->faker->randomNumber(4),
            'position' => $this->faker->numberBetween(1,50),
            'laps' => $this->faker->randomNumber(2),
            'quali_time' => $this->faker->randomNumber(5),
            'total_time' => $this->faker->randomNumber(7),
            'best_lap' => $this->faker->randomNumber(5),
            'race_number' => $this->faker->randomNumber(2),
            'penalty_points' => 0,
            'best_lap_points' => 0,
            'top_quali_points' => 0,
            'points' => 0,
            'final_points' => 0,
            'split' => 'AM',
        ];
    }
}
