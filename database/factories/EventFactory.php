<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;

class EventFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Event::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'session_id_sgp' => $this->faker->word,
            'session_name' => $this->faker->sentence,
            'track_name' => $this->faker->word,
            'series_id' => \App\Models\Series::factory(),
            'results_imported' => $this->faker->boolean,
            'registration_open' => $this->faker->boolean,
            'replay_url' => $this->faker->url,
        ];
    }
}
