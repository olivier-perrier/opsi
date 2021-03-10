<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
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
            'post_type_id' => PostType::factory()->make(),
            'name' => $this->faker->name,
            'user_id' => User::factory()->make(),
        ];
    }
}
