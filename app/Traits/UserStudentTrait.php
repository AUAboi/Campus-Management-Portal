<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Student;
use Error;

trait UserStudentTrait
{

  // HELPER TRAIT FOR ALL STUDENT RELATED STUFF

  public function createStudent($user, $request): Student
  {
    $student = $user->student()->create([
      'session_type' => $request->session_type,
      'registration_number' => $this->generateRegNumber(),
      'roll_no' => $request->roll_no ?? $user->id + 1,
      'admission_year' => Carbon::now()->year(),
    ]);

    if ($request->program) {
      $this->enrollStudent($student, $request->program);
    }

    $user->assignRole('student');

    return $student;
  }

  public function enrollStudent(Student $student, $program)
  {
    if ($student->program) {
      throw new Error('Student is already enrolled');
    }
    $student->update([
      'program_id' => $program
    ]);
  }

  public function generateRegNumber()
  {
    //Format: random 5 digits
    //append with admission year and branch name like
    // branch-year-registration

    $reg_number = rand(1, 9)  . rand(1, 9)   . rand(1, 9)  . rand(1, 9) .  rand(1, 9);
    if (Student::where('registration_number', $reg_number)->where('admission_year', Carbon::now()->year)->exists()) {
      $this->generateRegNumber();
    }
    return $reg_number;
  }
}
