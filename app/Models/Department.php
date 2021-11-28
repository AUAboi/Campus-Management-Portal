<?php

namespace App\Models;

use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;

class Department extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'department_name',
        'slug',
        'faculty_id'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('department_name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('department_name', 'like', '%' . $search . '%');
        });
    }
}
