<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\FacultyService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Http\Resources\FacultyCollection;
use App\Http\Resources\FacultyResource;
use App\Http\Resources\PermissionsResource;

//Permissions are for edit, delete, and create only. Every admin can view every faculty. Super admin can access every permission
class FacultyController extends Controller
{
    public function index(Request $request, FacultyService $facultyService)
    {
        $user = auth()->user();
        $filters = $request->all('search');

        $faculties = Faculty::when(auth()->user()->hasRole('super-admin'), function ($query) {
            return $query;
        })->when(!auth()->user()->hasRole('super-admin'), function ($query) {
            return $query->whereHas('admins', function ($query) {
                return $query->where('admin_id', '=', auth()->id());
            });
        })
            ->orderBy('faculty_name')
            ->filter($request->only('search'))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render("Admin/Faculties/Index", [
            'faculties' => new FacultyCollection($faculties),
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

    public function edit(Faculty $faculty)
    {
        $this->authorize('view', $faculty);

        $faculty->load('departments');

        return Inertia::render("Admin/Faculties/Edit", [
            'faculty' => new FacultyResource($faculty),
            'permissions' => new PermissionsResource($faculty)
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
