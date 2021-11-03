<?php

use App\Http\Controllers\Admin\FacultyController;
use PHPUnit\Framework\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\Student\CourseDetailsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route::inertia('/test', 'Test');

Route::get('/programs', [TestController::class, 'page']);

Route::get('/test', [TestController::class, 'index']);

Route::group(['middleware' => ['role:admin']], function () {
  Route::prefix('admin')->group(function () {
    //Dashboard
    Route::inertia('/dashboard', 'Admin/Dashboard/Index');

    //Profile
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index']);

    //Faculties
    Route::get('/faculties', [FacultyController::class, 'index']);
  });
});

Route::group(['middleware' => ['role:teacher']], function () {
  Route::prefix('teacher')->group(function () {
    Route::inertia('/dashboard', 'Teacher/DashboardPage');
  });
});

Route::group(['middleware' => ['role:student']], function () {
  Route::prefix('student')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, "index"]);
    Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'index']);
    Route::get('/course-details', [CourseDetailsController::class, 'index']);
  });
});
