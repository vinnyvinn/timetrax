<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        view()->composer(['partials.nav'], function ($view) {
            if (Auth::user()->employee) {
                return $view->with('checkin', Auth::user()->employee->attendance->where('time_out', null)->count() > 0 ? 'Check Out' : 'Check In');
            }

            return $view->with('checkin', null);
        });
        view()->composer(['partials.sidebar'], function ($view) {
            if(Cache::has(Setting::CACHE_KEY)) {
                return $view->with('configs', Cache::get(Setting::CACHE_KEY));
            }
            return $view->with('configs', Setting::all(['setting_key', 'setting_value']));
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
