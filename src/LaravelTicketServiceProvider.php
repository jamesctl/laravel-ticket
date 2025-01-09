<?php 

namespace Globit\LaravelTicket;

use Illuminate\Support\ServiceProvider;

class LaravelTicketServiceProvider extends ServiceProvider
{
     /**
     * Bootstrap ticket package services.
     *
     * @return void
     */
    public function boot()
    {
        // Register routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

}