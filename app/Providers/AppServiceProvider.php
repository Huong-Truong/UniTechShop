<?php

namespace App\Providers;
use Illuminate\Foundation\AliasLoader;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->register(\Maatwebsite\Excel\ExcelServiceProvider::class);
        $loader = AliasLoader::getInstance();
        $loader->alias('Excel', \Maatwebsite\Excel\Facades\Excel::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
