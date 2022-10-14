<?php

namespace App\Services\Admin;



use App\Models\User;
use App\Models\Faculty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FacultyService
{


  //Improve this
  public function getFaculties(User $user, array $filters)
  {

    if ($user->hasRole('super-admin')) {
      $faculties =  Faculty::orderBy('faculty_name')->filter($filters);
    } else {
      $faculties = $user->admin->faculties()->orderBy("faculty_name")->filter($filters);
    }

    return $faculties;
  }

  public function getFacultyDepartments(Faculty $faculty): Collection
  {
    return $faculty->departments()->orderBy('department_name')->get()->map->only('id', 'department_name', 'slug');
  }
}
