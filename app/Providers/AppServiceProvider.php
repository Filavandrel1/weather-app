<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::define('delete_post', function (User $user, Post $post) {
        //     return $user->id === $post->user_id || $user->role === Role::Admin;
        // });

        // Gate::define('update_post', function (User $user, Post $post) {
        //     return $user->id === $post->user_id || $user->role === Role::Admin;
        // });

        // Gate::define('delete_comment', function (User $user, Comment $comment) {
        //     return $user->id === $comment->user_id || $user->role === Role::Admin;
        // });
    }
}
