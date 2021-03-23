<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostType;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'posttype_id' => PostType::factory()->make(),
            'name' => $this->faker->name,
        ];
    }
}
