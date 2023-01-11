<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ProgramCollection;
use App\Http\Resources\ProgramResource;
use App\Http\Resources\UserResource;
use App\Models\ApplicationStatus;
use App\Models\Program;
use App\Services\AcademicDetailService;
use Composer\XdebugHandler\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function __construct()
    {
        //add middlewares
    }

    public function index(Request $request, AcademicDetailService $academicDetailService)
    {
        $applications = $request->user()->applications()->with(['program', 'program.department', 'program.degree', 'status'])->get()->transform(fn ($application) => [
            'program' => $application->program->full_program_name,
            'status' => $application->status->status,
        ]);


        return Inertia::render('Applicant/Applications/Index', [
            'user' => new UserResource($request->user()->load('academicDetails')),
            'applications' =>  $applications,
            'max_allowed' => config('constants.application.max_allowed'),
            'canApply' => empty($academicDetailService->availableAcademicTypes(auth()->user()))
        ]);
    }

    public function create(Request $request)
    {
        $applied_programs = auth()->user()->applications->pluck('program_id');

        $filters = $request->all('search');

        $programs =  Program::whereNotIn('id', $applied_programs)
            ->orderBy('slug')
            ->filter($request->only('search'))
            ->with(['department', 'degree'])
            ->paginate(10)
            ->withQueryString();

        return Inertia::render(
            'Applicant/Applications/Create',
            [
                'programs' => new ProgramCollection($programs),
                'max_allowed' => config('constants.application.max_allowed'),
                'filter' => $filters
            ]
        );
    }

    public function store(StoreApplicationRequest $request)
    {

        $program = Program::find($request->program_id);
        if ($request->user()->applications->contains('program_id', $program->id)) {
            return Redirect::route('applicant.applications')->with('error', 'Already applied to ' . $program->full_program_name);
        }
        $request->user()->applications()->create([
            'program_id' => $request->program_id,
            'status_id' => ApplicationStatus::where('status', 'waiting review')->first()->id
        ]);

        return Redirect::route('applicant.applications')->with('success', 'Applied to ' . $program->full_program_name . ' successfully');
    }
}
