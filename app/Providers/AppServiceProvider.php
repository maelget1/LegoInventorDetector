<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Debugbar;
use Illuminate\Support\Facades\Session;

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
        //
        if (app()->bound('debugbar')) {
            Debugbar::addCollector(new \DebugBar\DataCollector\ConfigCollector(Session::all(), 'Session'));
        }
    }
}
