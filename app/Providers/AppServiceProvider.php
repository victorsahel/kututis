<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path().'/Helpers/Jwt.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('valid_password', function($attribute, $value) {
            return preg_match('/^(?=.*[A-Z])(?=.*[~`¡!@#$%^&*()_\-+={[}\]|\\\\:;"\'<,>.¿?\/])(?!.*\s).*$/', $value);
        });
        Validator::extend('alpha_space', function($attribute, $value) {
            return preg_match('/^[\pL\s]*$/u', $value);
        });

    }
}
