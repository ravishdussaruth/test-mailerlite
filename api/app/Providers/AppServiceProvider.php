<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindAppServices();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Bind contracts to service in the container.
     *
     * @return void
     */
    protected function bindAppServices(): void
    {
        collect(config('app.services_binding'))->each(function ($serviceClass, $interface) {
            // Bind the interface to the service class.
            $this->app->bind($interface, $serviceClass);
        });
    }
}
