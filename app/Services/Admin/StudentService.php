<?php

namespace App\Services\Admin;

use App\Models\Program;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentService
{

  public function createUserStudent(array $data): User
  {
    $user = DB::transaction(function () use ($data) {
      $userService = new UserService();

      $created = $userService->createUser($data);

      $student = $created->student()->create([
        'session_type' => $data['session_type'],
        'registration_number' => $this->generateRegNumber(),
        'roll_no' => $data['roll_no'] ?? $created->id + 1,
        'session_start' => now()->year,
      ]);

      $created->assignRole('student');

      if ($data['program']) {
        $this->enroll($student, $data['program']);
      }

      return $created;
    });

    return $user;
  }


  public function enroll(Student $student, int $program)
  {
    $student->update([
      'program_id' => $program,
      'session_start' => now()->year
    ]);
  }


  public function generateRegNumber()
  {
    //Format: random 5 digits
    //append with admission year and branch name like
    // branch-year-registration

    $reg_number = rand(1, 9)  . rand(1, 9)   . rand(1, 9)  . rand(1, 9) .  rand(1, 9);
    if (Student::where('registration_number', $reg_number)->where('session_start', Carbon::now()->year)->exists()) {
      $reg_number = $this->generateRegNumber();
    }
    return $reg_number;
  }
}
