<?php

namespace App\Providers;

use App\Models\Api\Client;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::enableImplicitGrant();

        // Token expire in 15 minutes from now.
        Passport::tokensExpireIn(now()->addMinutes(15));

        // Use modified client model instead of Passport Default model.
        Passport::useClientModel(Client::class);
    }
}
