<?php

namespace App\Providers;

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
     * Share current user and flash messages with all views
     */
    public function boot(): void
    {
        // Share authenticated user with all views
        view()->composer('*', function ($view) {
            $view->with('currUser', auth()->user());
        });
    }
}

/*
view()->composer('*', ...)

Automatic sob view-er jonno run hoy ('*' = wildcard)
Laravel-e eta ke "View Composer" bola hoy
Blade template render howar age execute hoy
$view->with('currUser', auth()->user())

Sob view-te variable $currUser add kore
auth()->user() return kore:
- Logged-in user object jodi login kora thake
- null jodi login na kora thake
*/
