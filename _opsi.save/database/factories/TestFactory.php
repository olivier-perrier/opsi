<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class TestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Test::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'valueId' => $this->faker->randomNumber(1),
            'realValue' => $this->faker->randomFloat(5),
            'timestamp' => Date::now(),   
            // 'valueId' => 5,
            // 'realValue' => 5.5,
            // 'timestamp' => '2006-06-20 02:07:41',
        ];
    }
}
