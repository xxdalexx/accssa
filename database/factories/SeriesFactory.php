<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Series;

class SeriesFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Series::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'top_point' => $this->faker->randomNumber(2),
            'penalty_points' => $this->faker->boolean,
            'splits' => $this->faker->boolean,
            'drop_one_standings' => $this->faker->boolean,
            'registration_locked' => $this->faker->boolean,
            'registration_open' => $this->faker->boolean,
            'archived' => $this->faker->boolean,
            'vehicle_change_locked' => $this->faker->boolean,
        ];
    }
}
