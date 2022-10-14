<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Faculty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Permission\Contracts\Role;
use App\Services\Admin\FacultyService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;

//Permissions are for edit, delete, and create only. Every admin can view every faculty. Super admin can access every permission
class FacultyController extends Controller
{
    public function index(Request $request, FacultyService $facultyService)
    {

        $user = auth()->user();
        $filters = $request->all('search');

        $faculties = $facultyService->getFaculties($user, $filters);

        return Inertia::render("Admin/Faculties/Index", [
            'faculties' => $faculties->paginate(10)->withQueryString(),

            'filters' => $filters,
            'permissions' => [
                'create' => $user->can('create', Faculty::class),
            ],

        ]);
    }

    public function create()
    {
        $this->authorize('create', Faculty::class);
        return Inertia::render("Admin/Faculties/Create");
    }

    public function edit(Faculty $faculty, FacultyService $facultyService)
    {
        $this->authorize('view', $faculty);

        return Inertia::render("Admin/Faculties/Edit", [
            'faculty' => [
                'id' => $faculty->id,
                'faculty_name' => $faculty->faculty_name,
                'slug' => $faculty->slug,
                'departments' => $facultyService->getFacultyDepartments($faculty),
            ],
            'permissions' => [
                'update' => auth()->user()->can('update', $faculty),
                'delete' => auth()->user()->can('delete', $faculty),
            ],
        ]);
    }

    public function store(StoreFacultyRequest $request)
    {
        $this->authorize('create', Faculty::class);

        Faculty::create($request->validated());
        return Redirect::route('admin.faculties')->with('success', 'Faculty created.');
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $this->authorize('update', $faculty);

        $faculty->update($request->validated());

        return Redirect::route('admin.faculties')->with('success', 'Faculty updated.');
    }

    public function destroy(Faculty $faculty)
    {
        $this->authorize('delete', $faculty);

        $faculty->delete();
        return Redirect::route('admin.faculties')->with('success', 'Faculty deleted.');
    }
}
