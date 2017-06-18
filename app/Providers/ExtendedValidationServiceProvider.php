<?php

namespace App\Providers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ExtendedValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('empty_when', function ($attribute, $value, $parameters, $validator)
        {
            foreach ($parameters as $key)
            {
                if ( ! empty(Input::get($key)))
                {
                    return false;
                }
            }

            return true;
        });

        Validator::replacer('empty_when', function ($message, $attribute, $rule, $parameters) {
            return 'The '. $attribute . ' field allowed when ' . implode(" / ", $parameters) . ' is not present.';
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
