<?php

namespace App\Providers;

use App\Contracts\PaymentGateway;
use App\Services\AuthService;
use App\Services\ProfileService;
use App\Services\StripePaymentService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Google\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $credentials = match($this->app->isProduction()){
            true=>config('payment.stripe.production'),
            default => config('payment.stripe.local')
        };

        $this->app->bind(PaymentGateway::class, function () use ($credentials){
            return new StripePaymentService($credentials);
        });

        $this->app->bind(ProfileService::class, function (){
            return new ProfileService();
        });

        $this->app->singleton(AuthService::class, function (){
            return new AuthService(
                new Client()
            );
        });

        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->isProduction()
                ? $rule
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised()
                : $rule;
        });
    }
}
