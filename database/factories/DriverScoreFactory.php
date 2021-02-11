<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DriverScore;

class DriverScoreFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = DriverScore::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'driver_id' => \App\Models\Driver::factory(),
            'barcelona' => $this->faker->randomNumber(),
            'brands_hatch' => $this->faker->randomNumber(),
            'barcelona_2019' => $this->faker->randomNumber(),
            'brands_hatch_2019' => $this->faker->randomNumber(),
            'hungaroring' => $this->faker->randomNumber(),
            'hungaroring_2019' => $this->faker->randomNumber(),
            'kyalami_2019' => $this->faker->randomNumber(),
            'laguna_seca_2019' => $this->faker->randomNumber(),
            'misano' => $this->faker->randomNumber(),
            'misano_2019' => $this->faker->randomNumber(),
            'monza' => $this->faker->randomNumber(),
            'monza_2019' => $this->faker->randomNumber(),
            'mount_panorama_2019' => $this->faker->randomNumber(),
            'nurburgring' => $this->faker->randomNumber(),
            'nurburgring_2019' => $this->faker->randomNumber(),
            'paul_ricard' => $this->faker->randomNumber(),
            'paul_ricard_2019' => $this->faker->randomNumber(),
            'silverstone' => $this->faker->randomNumber(),
            'silverstone_2019' => $this->faker->randomNumber(),
            'spa' => $this->faker->randomNumber(),
            'spa_2019' => $this->faker->randomNumber(),
            'suzuka_2019' => $this->faker->randomNumber(),
            'zandvoort' => $this->faker->randomNumber(),
            'zandvoort_2019' => $this->faker->randomNumber(),
            'zolder' => $this->faker->randomNumber(),
            'zolder_2019' => $this->faker->randomNumber(),
            'barcelona_2020' => $this->faker->randomNumber(),
            'brands_hatch_2020' => $this->faker->randomNumber(),
            'hungaroring_2020' => $this->faker->randomNumber(),
            'misano_2020' => $this->faker->randomNumber(),
            'monza_2020' => $this->faker->randomNumber(),
            'nurburgring_2020' => $this->faker->randomNumber(),
            'paul_ricard_2020' => $this->faker->randomNumber(),
            'silverstone_2020' => $this->faker->randomNumber(),
            'spa_2020' => $this->faker->randomNumber(),
            'zandvoort_2020' => $this->faker->randomNumber(),
            'zolder_2020' => $this->faker->randomNumber(),
            'imola_2020' => $this->faker->randomNumber(),
        ];
    }
}
