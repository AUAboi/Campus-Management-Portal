<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_name'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }


    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }


    //->filter scope

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('faculty_name', 'like', '%' . $search . '%');
        });
    }
}
