<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Enums\Role;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Policies\PolicyForComment;
use App\Policies\PolicyForPost;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Post::class => PolicyForPost::class,
        // Comment::class => PolicyForComment::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate::define('delete_post', [PolicyForPost::class, 'delete']);

        // Gate::define('update_post', [PolicyForPost::class, 'update']);

        // Gate::define('delete_comment', [PolicyForComment::class, 'delete']);
    }
}
