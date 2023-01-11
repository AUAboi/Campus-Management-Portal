<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Services\AcademicDetailService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\AcademicDetailsResource;
use App\Http\Requests\StoreAcademicDetailRequest;

class AcademicDetailsController extends Controller
{
    public function index(AcademicDetailService $academicDetailService)
    {
        return Inertia::render('Applicant/AcademicDetails/Index', [
            'academic_details' =>  AcademicDetailsResource::collection(auth()->user()->academicDetails->load('organization')),
            'canAdd' => !empty($academicDetailService->availableAcademicTypes(auth()->user()))
        ]);
    }

    public function create(AcademicDetailService $academicDetailService)
    {
        if (empty($academicDetailService->availableAcademicTypes(auth()->user()))) {
            return Redirect::route('applicant.academic-details')->with('error', 'Already added all details. Delete previous if you want to add again');
        }

        return Inertia::render('Applicant/AcademicDetails/Create', [
            'organizations' => Organization::all(),
            'degreeTypes' => $academicDetailService->availableAcademicTypes(auth()->user())
        ]);
    }

    public function store(AcademicDetailService $academicDetailService, StoreAcademicDetailRequest $request)
    {
        if (empty($academicDetailService->availableAcademicTypes(auth()->user()))) {
            return Redirect::route('applicant.academic-details')->with('error', 'Already added all details. Delete previous if you want to add again');
        }

        auth()->user()->academicDetails()->create($request->validated());
        return Redirect::route('applicant.academic-details')->with('success', 'Added successfully!');
    }
}
