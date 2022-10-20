<?php

use App\Http\Controllers\AcademicDetailsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\ApplicantController;
use App\Http\Controllers\ApplicationController;

//applicant routes

Route::group(['middleware' => ['role:applicant']], function () {
  Route::prefix('applicant')->group(function () {
    Route::get('/dashboard', [ApplicantController::class, 'dashboard'])->name('applicant.dashboard');

    //Applications for applicant
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applicant.applications');


    Route::get('/academic_details', [AcademicDetailsController::class, 'index'])->name('applicant.academic-details');
    Route::get('/academic_details/add', [AcademicDetailsController::class, 'create'])->name('applicant.academic-details.create');
  });
});
