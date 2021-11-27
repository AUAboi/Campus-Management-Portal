<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class);
    }


    //hack to make department relation on admin model
    //using admin_faculty pivot table to get the department by joining the departments table with admin_faculty table using faculty_id as key
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'admin_faculty', 'admin_id', 'faculty_id', 'id', 'faculty_id');
    }
}
