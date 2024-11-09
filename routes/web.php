<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\HomeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\Sections\MatierController;
use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Students\FeesController;
use App\Http\Controllers\Students\FeesInvoicesController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\ProcessingFeeController;
use App\Http\Controllers\Students\PromotionController;
use App\Http\Controllers\Students\ReceiptStudentsController;
use App\Http\Controllers\Teachers\TeacherController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Grades\ZoomMeetingController;
use App\Http\Controllers\Librarys\LibraryController;
use App\Http\Controllers\settings\SettingController;
use Livewire\Livewire; // Ensure Livewire is imported

// Authentication routes
//Auth::routes(); default laravel 

// Guest routes
/*Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});*/


/*Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');*/
Route::get('/', [HomeController::class, 'index'])->name('selection');
//Route::get('/',    [LoginController::class, 'ok']);

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login/{type}',    [LoginController::class, 'loginForm'])->middleware('guest')->name('login.show');
    
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout/{type}', [LoginController::class, 'logout'])->name('logout');
  //  Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->middleware('guest')->name('register');

    
    });
// Public routes
// Public routes
Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('selection');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('/login/{type}', [LoginController::class, 'loginForm'])->middleware('guest')->name('login.show');
        Route::post('/logout/{type}', [LoginController::class, 'logout'])->name('logout');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->middleware('guest')->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    });

// Protected routes
/*Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth']) njm zada
    ->group(function () {*/
Route::middleware(['auth:web'])->group(function () {
    Route::prefix(LaravelLocalization::setLocale())->middleware(['localize', 'localizationRedirect', 'localeSessionRedirect'])->group(function () {
        // Dashboard route
        /*Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');*/
//Route::get('/', [HomeController::class, 'index'])->name('selection');
Route::get('/dashboard',[HomeController::class, 'dashboard'])->name('dashboard');

      //  Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::resource('Grades', GradeController::class);
        Route::post('/grades/create-meeting', [GradeController::class, 'createMeeting'])->name('Grades.createMeeting');

        Route::resource('Classrooms', ClassroomController::class);
        Route::post('delete_all', [ClassroomController::class, 'delete_all'])->name('delete_all');
        Route::resource('Sections', SectionController::class);
        Route::get('/classes/{grade_id}', [SectionController::class, 'getclasses'])->name('getClasses');

        // Livewire component view
        Route::view('add_parent', 'livewire.show_Form')->name('add_parent');
        Route::view('show_parent', 'livewire.show_table');
        Route::resource('Teachers', TeacherController::class); 
        /*Route::group(['namespace' => 'Students'], function () {*/
            Route::resource('Students', StudentController::class);
            Route::get('/Get_classrooms/{id}', [StudentController::class, 'Get_classrooms']);

            Route::get('/Get_Sections/{id}', [StudentController::class, 'Get_Sections']);
            Route::post('Upload_attachment', [StudentController::class, 'Upload_attachment'])->name('Upload_attachment');
            Route::get('Download_attachment/{studentsname}/{filename}', [StudentController::class, 'Download_attachment'])->name('Download_attachment');
            Route::post('Delete_attachment', [StudentController::class, 'Delete_attachment'])->name('Delete_attachment');
            Route::resource('Promotion', PromotionController::class);
            Route::get('/GetStudentsBySection/{section_id}', [PromotionController::class, 'getStudentsBySection'])->name('GetStudentsBySection');
            Route::resource('Graduated', GraduatedController::class);
            Route::resource('Fees', FeesController ::class);
            Route::resource('Fees_Invoices',  FeesInvoicesController ::class);
            Route::get('/Get_Amount/{id}', [FeesInvoicesController::class, 'Get_Amount']);
            Route::resource('receipt_students', ReceiptStudentsController::class);
            Route::resource('ProcessingFee', ProcessingFeeController::class);
            Route::resource('Attendance', AttendanceController::class);
            Route::resource('Matier', MatierController::class);
           // Route::get('/list-meetings', [GradeController::class, 'listMeetings'])->name('listMeetings');

//Route::post('/create-meeting', [ZoomMeetingController::class, 'createMeeting']);
           Route::get('download_file/{filename}', [LibraryController::class, 'downloadAttachment'])->name('downloadAttachment');

           Route::resource('library', LibraryController::class);
           Route::resource('settings', SettingController::class);









       /* });*/


    });
});

// Custom route for loading Livewire JS (optional, customize path as needed)
Route::get('/custom/livewire/livewire.js', function () {
    return response()->file(public_path('custom/livewire.js'));
});

// Set Livewire update route to handle the localization prefix
Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/ar/livewire/update', $handle); // Use '/ar' based on your localized URL
});

