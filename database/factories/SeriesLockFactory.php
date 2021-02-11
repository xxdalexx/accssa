<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SeriesLock;

class SeriesLockFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = SeriesLock::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'driver_id' => \App\Models\Driver::factory(),
            'series_id' => \App\Models\Series::factory(),
            'split' => $this->faker->word,
            'car_id' => $this->faker->randomNumber(),
        ];
    }
}
