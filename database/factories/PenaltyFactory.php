<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Penalty;

class PenaltyFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Penalty::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'description' => $this->faker->text,
            'points' => $this->faker->randomNumber(),
            'protected' => $this->faker->boolean,
        ];
    }
}
