<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Incident;

class IncidentFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Incident::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'accused_id' => \App\Models\Driver::factory(),
            'victim_id' => \App\Models\Driver::factory(),
            'reported_by_id' => \App\Models\User::factory(),
            'penalty_id' => \App\Models\Penalty::factory(),
            'event_id' => $this->faker->randomNumber(),
            'timestamp' => $this->faker->word,
            'description' => $this->faker->text,
            'reviewers_notes' => $this->faker->text,
            'status' => $this->faker->word,
            'penalty_applied' => $this->faker->boolean,
            'first_lap' => $this->faker->boolean,
        ];
    }
}
