<?php

namespace App\Providers;

use App\Http\Interfaces\GroupsContracts;
use App\Http\Services\GroupsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GroupsContracts::class, function () {
            return new GroupsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
