<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//==============================Translate all pages============================
Route::middleware(['auth:student'])->group(function () {
    Route::prefix(LaravelLocalization::setLocale())->middleware(['localize', 'localizationRedirect', 'localeSessionRedirect'])->group(function () {
        Route::get('/student/dashboard', function () {
            return view('pages.Students.dashboard');
        });
    });
});
