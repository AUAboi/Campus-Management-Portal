<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminService
{


  public function createUserAdmin(array $data): User
  {
    $user = DB::transaction(function () use ($data) {
      $userService = new UserService();
      $created = $userService->createUser($data);
      $created->assignRole('admin');
      $created->admin()->create();
      return $created;
    });

    return $user;
  }

  public function updateUserAdmin(array $data, User $user)
  {

    DB::transaction(function () use ($data, $user) {
      $this->updateAdminPermissions($data['permissions'], $user);
      $this->assignAdminFaculties($data['faculties'], $user);


      $user->update(['name' => $data['name']]);
    });
  }


  protected function updateAdminPermissions(array $permissions, User $user)
  {
    $user->syncPermissions(array_keys(array_filter($permissions)));
  }

  protected function assignAdminFaculties(array $faculties, User $user)
  {

    $faculties_id = array_filter($faculties, function ($faculty) {
      return $faculty['owns_faculty'] == true;
    });

    $faculties_id = array_map(function ($faculty) {
      return $faculty['id'];
    }, $faculties_id);


    $user->admin->faculties()->sync($faculties_id);
  }
}
