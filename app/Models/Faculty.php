<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Department;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'faculty_name',
        'slug'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function ($model) {
                return "faculty " . "$model->faculty_name";
            })
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }


    public function admins()
    {
        return $this->belongsToMany(User::class, 'admin_faculty', 'faculty_id', 'admin_id', 'id', 'id');
    }


    //->filter scope

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('faculty_name', 'like', '%' . $search . '%');
        });
    }
}
