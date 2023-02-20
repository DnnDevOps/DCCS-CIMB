<?php

namespace ObeliskAdmin\Providers;

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
        \Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            $passwordHash = \Auth::user()->password;

            return \Hash::check($value, $passwordHash);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
