<?php

namespace Database\Factories;

use App\Models\Authorization;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Authorization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
