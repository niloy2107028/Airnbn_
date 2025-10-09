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
     * Equivalent to Node.js: res.locals.currUser = req.user;
     */
    public function boot(): void
    {
        // Share authenticated user with all views
        view()->composer('*', function ($view) {
            $view->with('currUser', auth()->user());
        });
    }
}
