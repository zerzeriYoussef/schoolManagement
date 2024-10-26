<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {    Livewire::setScriptRoute(function ($handle) {
        return Route::get('/custom/livewire/livewire.js', $handle);
    });


        \Livewire\Livewire::setUpdateRoute(function () {
            return \Illuminate\Support\Facades\Route::post(
                '/custom/livewire/update',
                [\Livewire\Mechanisms\HandleRequests\HandleRequests::class, 'handleUpdate']
            ); // No middleware
        });
    }
    
    



}