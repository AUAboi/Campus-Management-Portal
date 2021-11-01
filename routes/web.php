<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\CourseDetailsController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\TestController;
use PHPUnit\Framework\Test;

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

Route::group(['middleware' => ['role:teacher']], function () {
  Route::prefix('teacher')->group(function () {
    Route::inertia('/dashboard', 'Teacher/DashboardPage');
  });
});

Route::group(['middleware' => ['role:student']], function () {
  Route::prefix('student')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, "index"]);
    Route::get('/profile', [StudentProfileController::class, 'index']);
    Route::get('/course-details', [CourseDetailsController::class, 'index']);
  });
});
