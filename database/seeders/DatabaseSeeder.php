<?php

namespace Database\Seeders;

use App\Models\Authorization;
use App\Models\Field;
use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User
        $user = User::factory(1)->create(['email' => 'olivier.perrier.j@gmail.com']);
        User::factory(1)->create(['email' => 'client@gmail.com']);

        $page = PostType::factory()->create(['name' => 'Page']);
        $post = PostType::factory()->create(['name' => 'Post']);
        $client = PostType::factory()->create(['name' => 'Client']);
        $contrat = PostType::factory()->create(['name' => 'Contrat']);

        Authorization::factory()->create(['name' => 'Auth1']);

        // Fields
        // Field::factory()->for($contrat)->create(['name' => 'Client', 'type' => 'Relationship']);
        // Field::factory()->for($contrat)->create(['name' => 'Date', 'type' => 'Date']);

        // Posts
        // Post::factory()->for($page)->create(['name' => 'Page 1']);
        // Post::factory()->create(['name' => 'Page 1']);
        // Post::factory()->for($post)->create(['name' => 'Post 1']);
        // Post::factory()->for($client)->create(['name' => 'Client 1']);
        // Post::factory()->for($contrat)->create(['name' => 'Contrat 1']);

    }
}
