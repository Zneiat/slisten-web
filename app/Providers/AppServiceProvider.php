<?php

namespace App\Providers;

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
        /** @link http://d.laravel-china.org/docs/5.4/migrations#索引长度--MySQL--MariaDB */
        Schema::defaultStringLength(191);
    
        /** @link http://d.laravel-china.org/docs/5.4/blade#拓展-Blade */
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /** @link https://packagist.org/packages/barryvdh/laravel-ide-helper */
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
