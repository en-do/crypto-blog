<?php

namespace App\Providers;

use App\Models\PostTemplate;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Post;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();



        Gate::define('post-update', function (User $user, Post $post) {
            return $user->id == $post->user_id;
        });

        Gate::define('post-delete', function (User $user, Post $post) {
            return $user->id == $post->user_id;
        });

        Gate::define('template-update', function (User $user, PostTemplate $template) {
            return $user->id == $template->user_id;
        });

        Gate::define('template-delete', function (User $user, PostTemplate $template) {
            return $user->id == $template->user_id;
        });


        Gate::before(function (User $user) {
            if($user->role->key == 'admin') {
                return true;
            }
        });


    }
}
