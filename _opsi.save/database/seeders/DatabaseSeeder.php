<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $page = \App\Models\PostType::factory()->create(['name' => 'Page']);
        $post = \App\Models\PostType::factory()->create(['name' => 'Post']);
        $menu = \App\Models\PostType::factory()->create(['name' => 'Menu']);
        $menuItem = \App\Models\PostType::factory()->create(['name' => 'Menu Item']);
        $setting = \App\Models\PostType::factory()->create(['name' => 'Setting']);
        $client = \App\Models\PostType::factory()->create(['name' => 'Client']);
        $contrat = \App\Models\PostType::factory()->create(['name' => 'Contrat']);

        // Fields
        \App\Models\Field::factory()->for($contrat)->create(['name' => 'Client', 'type' => 'Relationship']);

        // Posts
        $postPage = \App\Models\Post::factory()->for($page)->create(['name' => 'Home', 'content' => 'Content of the page']);
        \App\Models\Post::factory()->for($post)->create(['name' => 'Post 1']);
        \App\Models\Post::factory()->for($menu)->create(['name' => 'Main menu']);
        $postMenuItem = \App\Models\Post::factory()->for($menuItem)->create(['name' => 'Google', 'content' => 'www.google.fr']);
        \App\Models\Post::factory()->for($client)->create(['name' => 'Client 1']);
        \App\Models\Post::factory()->for($contrat)->create(['name' => 'Contrat 1']);

        \App\Models\Post::factory()->for($setting)->create(['name' => 'siteName', 'content' => 'OPSI']);
        \App\Models\Post::factory()->for($setting)->create(['name' => 'favicon', 'content' => 'icon.ico']);
    }
}
