<?php

use App\Http\Controllers\Teachers\dashboard\ProfileController;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Teachers\dashboard\StudentController;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
Route::middleware(['auth:teacher'])->group(function () {
    Route::prefix(LaravelLocalization::setLocale())->middleware(['localize', 'localizationRedirect', 'localeSessionRedirect'])->group(function () {
        Route::get('/teacher/dashboard', function () {
            $teacher = Auth::guard('teacher')->user();  // Use the explicit guard

            $data['Teachers']=Teacher::all();

           $ids = Teacher::findorFail($teacher->id)->Sections()->pluck('section_id');
            $data['count_sections']= $ids->count();
            $data['count_students']= \App\Models\Student::whereIn('section_id',$ids)->count();
    
     //      $ids = DB::table('teacher_section')->where('teacher_id',auth()->user()->id)->pluck('section_id');
    //        $count_sections =  $ids->count();
    //        $count_students = DB::table('students')->whereIn('section_id',$ids)->count();
            return view('pages.Teachers.dashboard',$data);   
             });
             Route::group(['namespace' => 'Teachers\dashboard'], function () {
                //==============================students============================
             Route::get('student', [StudentController::class, 'index'])->name('student.index');
             Route::get('sections', [StudentController::class, 'sections'])->name('sections');
             Route::post('attendance', [StudentController::class, 'attendance'])->name('attendance');
             Route::post('edit_attendance', [StudentController::class, 'editAttendance'])->name('attendance.edit');
             Route::get('attendance_report',[StudentController::class, 'attendanceReport'])->name('attendance.report');
             Route::post('attendance_report',[StudentController::class, 'attendanceSearch'])->name('attendance.search');
             Route::get('profile', [ProfileController::class,'index'])->name('profile.show');
             Route::post('profile/{id}', [ProfileController::class,'update'])->name('profile.update');

            });
      
    });
});
