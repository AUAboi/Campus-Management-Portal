<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function __construct()
    {
        //add middlewares
    }

    public function index(Request $request)
    {
        $applications = $request->user()->applications()->with(['program', 'program.department', 'program.degree', 'status'])->get()->transform(fn ($application) => [
            'program' => $application->program->full_program_name,
            'status' => $application->status->status,
        ]);


        return Inertia::render('Applicant/Applications/Index', [
            'user' => new UserResource($request->user()->load('academicDetails')),
            'applications' =>  $applications,
            'max_allowed' => config('constants.application.max_allowed')
        ]);
    }
}
