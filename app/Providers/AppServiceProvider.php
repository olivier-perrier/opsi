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

            // dd(Auth::user()->authorization->authorizationPosttypes->where('read', true));
            $view->with('autorization', Auth::user()->authorization->authorizationPosttypes->where('read', true));

            $view->with('postTypes', Auth::user()->organization->postTypes);

        });
    }
}
