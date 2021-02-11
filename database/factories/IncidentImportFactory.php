<?php

namespace Database\Factories;

use App\Models\IncidentImport;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncidentImportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IncidentImport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'replay_timestamp' => $this->faker->word,
        ];
    }
}
