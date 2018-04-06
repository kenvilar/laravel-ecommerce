<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserEmailChanged;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        User::created(function ($user) {
            retry(5, function () use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            }, 100);
        });

        User::updated(function ($user) {
            if (!$user->isClean('email')) {
                retry(5, function () use ($user) {
                    Mail::to($user)->send(new UserEmailChanged($user));
                }, 100);
            }
        });

        Product::updated(function ($product) {
            if ($product->quantity === 0 && $product->isAvailable()) {
                $product->status = Product::UNAVAILABLE;

                $product->save();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
