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
                // echo $item->posttypes . '</br>';
                // echo 'carry = ' . $carry . '</br>';
                // dd($carry->concat($carry, $item->posttypes));
                return $carry->concat($item->posttypes->get()); //where('hidden', '=', true));
            }, collect([]));

            // dd($menuSidebar);

            // $view->with('menuSidebar', $menuSidebar->unique('name'));

            $view->with('menuSidebar', PostType::all());

        });
    }
}
