<?php

use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\Student\CourseDetailsController;
use App\Models\Program;

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
    Route::put('/departments/{department}/update', [DepartmentController::class, 'update'])->name('admin.departments.update');
    Route::delete('/departments/{department}/delete', [DepartmentController::class, 'destroy'])->name('admin.departments.destroy');

    //Programs
    Route::get('/programs', [ProgramController::class, 'index'])->name('admin.programs');
    Route::get('/programs/create', [ProgramController::class, 'create'])->name('admin.programs.create');
    Route::get('/programs/{program}/edit', [ProgramController::class, 'edit'])->name('admin.programs.edit');

    //Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

    Route::post('/users/create', [UserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{user}/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('admin.users.destroy');
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
