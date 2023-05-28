<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\RateObserver;
use App\Models\Rate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Carts\CartsRepositoryInterface::class,
            \App\Repositories\Carts\CartsRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Orders\OrdersRepositoryInterface::class,
            \App\Repositories\Orders\OrdersRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Products\ProductsRepositoryInterface::class,
            \App\Repositories\Products\ProductsRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Rates\RatesRepositoryInterface::class,
            \App\Repositories\Rates\RatesRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Users\UsersRepositoryInterface::class,
            \App\Repositories\Users\UsersRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Rate::observe(RateObserver::class);
    }
}
