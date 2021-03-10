<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_type_id' => PostType::factory()->make(),
            'name' => $this->faker->name,
            'type' => 'Text',
        ];
    }
}
