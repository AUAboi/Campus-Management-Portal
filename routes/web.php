<?php

use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\DepartmentController;
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
    Route::inertia('/dashboard', 'Admin/Dashboard/Index')->name('admin.dashboard');

    //Profile
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile');

    //Faculties
    Route::get('/faculties', [FacultyController::class, 'index'])->name('admin.faculties');
    Route::get('/faculties/create', [FacultyController::class, 'create'])->name('admin.faculties.create');
    Route::get('/faculties/{faculty}/edit', [FacultyController::class, 'edit'])->name('admin.faculties.edit');

    Route::post('/faculties/create', [FacultyController::class, 'store'])->name('admin.faculties.store');
    Route::put('/faculties/{faculty}/update', [FacultyController::class, 'update'])->name('admin.faculties.update');
    Route::delete('/faculties/{faculty}/delete', [FacultyController::class, 'destroy'])->name('admin.faculties.destroy');

    //Departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('admin.departments');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('admin.departments.create');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('admin.departments.edit');

    Route::post('/departments/create', [DepartmentController::class, 'store'])->name('admin.departments.store');
  });
});

Route::group(['middleware' => ['role:teacher']], function () {
  Route::prefix('teacher')->group(function () {
    Route::inertia('/dashboard', 'Teacher/DashboardPage');
  });
});

Route::group(['middleware' => ['role:student']], function () {
  Route::prefix('student')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, "index"])->name('student.dashboard');
    Route::get('/profile', [App\Http\Controllers\Student\ProfileController::class, 'index'])->name('student.profile');
    Route::get('/course-details', [CourseDetailsController::class, 'index'])->name('student.course-details');
  });
});
