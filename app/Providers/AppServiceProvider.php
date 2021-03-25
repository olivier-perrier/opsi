<?php

namespace App\Providers;

use App\Models\PostType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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


        View::composer('layouts.app', function ($view) {
            $menuSidebar = Auth::user()->authorizations->reduce(function ($carry, $item) {
                return $carry->union($item->posttypes);
            }, collect([]));

            $view->with('menuSidebar', $menuSidebar);
        });


        // if (Schema::hasTable('posttypes')) {
        //     View::share('menuSidebar', PostType::all());
        // }
    }
}
