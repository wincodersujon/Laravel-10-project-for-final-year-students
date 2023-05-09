<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //for responsive paginate list of item links
        Paginator::useBootstrap();

        //Website name change ->[layout.sujon.navbar]
        $websiteSetting = Setting::first();
        View::share('appSetting', $websiteSetting);
    }
}
