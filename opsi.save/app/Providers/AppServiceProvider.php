<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\PostType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('sidebarMenus', PostType::all());

        View::share(
            'page_home',
            PostType::where('name', 'Page')->first()
                ->posts()->where('name', 'Home')->firstOrFail()
        );

        View::share('posttypes', PostType::all()
            ->reduce(function ($carry, $posttype) {
                $carry->put($posttype->name, $posttype);
                return $carry;
            }, collect()));


        View::share('menus', PostType::where('name', 'Menu')->first()
            ->posts()->get()
            ->reduce(function ($carry, $menu) {
                $carry->put($menu->name, $menu);
                return $carry;
            }, collect()));


        Blade::directive('getSetting', function ($settingName) {
            return PostType::all()->where('name', 'Setting')->first()
                ->posts()->where('name', $settingName)->firstOrFail()
                ->content;
        });


        // to delete
        View::share('template', Post::find(8));
    }
}
