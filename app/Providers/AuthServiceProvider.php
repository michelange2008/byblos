<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Book;
use App\Models\Comment;
use App\Policies\BookPolicy;
use App\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Lier le modèle Book à sa Policy
        Book::class => BookPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Exemple : définir un gate "is-me" si tu veux l'utiliser ailleurs
        Gate::define('is-me', function ($user) {
            return $user->email === 'michelange@wanadoo.fr';
        });
    }
}
