<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;


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
        // Auth::viaRequest('custom', function ($request) {
        //     if (Auth::check() && Auth::user()->is_banned) {
        //         Auth::logout();
        //         session()->flash('banned', true); // Set the banned session variable
        //         return redirect()->route('login'); // Redirect to the login page
        //     }
        // });
    }
}
