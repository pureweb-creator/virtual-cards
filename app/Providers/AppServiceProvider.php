<?php

namespace App\Providers;

use App\Contracts\PaymentGateway;
use App\Services\EpayPaymentService;
use App\Services\ProfileService;
use App\Services\StripePaymentService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
                    ->symbols()
                    ->uncompromised()
                : $rule;
        });
    }
}
