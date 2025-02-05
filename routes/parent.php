<?php

use App\Http\Controllers\Parents\ChildrenController;
use App\Http\Controllers\Teachers\dashboard\ProfileController;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Teachers\dashboard\StudentController;
use App\Models\Student;
use Symfony\Component\HttpKernel\Profiler\Profile;

Route::middleware(['auth:parent'])->group(function () {
    Route::prefix(LaravelLocalization::setLocale())->middleware(['localize', 'localizationRedirect', 'localeSessionRedirect'])->group(function () {

        Route::get('/parent/dashboard', function () {
            $sons = Student::where('parent_id',auth('parent')->user()->id)->get();

            return view('pages.parents.dashboard',compact('sons'));
        })->name('dashboard.parents');
        Route::group(['namespace' => 'Parents\dashboard'], function () {
            Route::get('children', [ChildrenController::class, 'index'])->name('sons.index');
        //    Route::get('results/{id}', [\App\Http\Controllers\Parents\dashboard\ChildrenController::class, 'results'])->name('sons.results');
            });

    });
    

});