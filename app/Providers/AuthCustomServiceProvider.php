<?php

namespace App\Providers;

use App\Interface\AuthentificationInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\AuthentificationServiceInterface;
use App\Services\Auth\AuthentificationPassport;
use App\Services\AuthentificationSanctum;

class AuthCustomServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Binding the interface to the Passport implementation by default
        $this->app->bind(AuthentificationInterface::class, AuthentificationPassport::class);
    }

    public function boot()
    {
        //
    }
}
