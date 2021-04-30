<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-post', function (User $user, Post $post) {
            return $user->authorized_posttypes()->contains('name', $post->postType->name)
                || $user->email == 'olivier.perrier.j@gmail.com';;
        });

        Gate::define('manage-posttype', function (User $user, PostType $postType) {
            return $user->authorized_posttypes()->contains('name', $postType->name)
                || $user->email == 'olivier.perrier.j@gmail.com';
        });

        Gate::define('manage-users', function (User $user, User $targteUser = null) {
            return $user->authorized_posttypes()->contains('name', 'User')
                || $user->email == 'olivier.perrier.j@gmail.com';
        });

        Gate::define('manage-authorizations', function (User $user) {
            return $user->authorized_posttypes()->contains('name', 'Authorization')
                || $user->email == 'olivier.perrier.j@gmail.com';
        });

        Gate::define('manage-posttypes', function (User $user) {
            return $user->authorized_posttypes()->contains('name', 'Posttype')
                || $user->email == 'olivier.perrier.j@gmail.com';
        });
    }
}
