<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // time
        // Carbon::setLocale(config('app.locale'));
        date_default_timezone_set('Europe/Berlin');
        
        // pagination
        Paginator::useBootstrap();

        // never sent a message to a real email when developing this application
        if ($this->app->environment('local')) {
            // Mail::alwaysTo('info@blubber-lounge.de');
            Mail::alwaysTo('maximilian.mewes@gmx.de');
        }
    }
}
