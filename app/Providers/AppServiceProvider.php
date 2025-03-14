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
        Auth::viaRequest('custom', function ($request) {
            if (Auth::check() && Auth::user()->is_banned) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account has been banned.');
            }
        });
    }
}
