<?php

namespace App\Models;

use App\Models\Degree;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;

class Program extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'department_id',
        'degree_id',
        'credit_hours',
        'slug'
    ];


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(function ($model) {
                return "{$model->degree->degree_name} {$model->department->department_name}";
            })
            ->saveSlugsTo('slug');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->WhereHas('department', function ($query) use ($search) {
                $query->where('department_name', 'like', "%{$search}%");
            });
        })->when($filters['degree'] ?? null, function ($query, $degree) {
            $query->whereHas('degree', function ($query) use ($degree) {
                $query->where('degree_name', 'like', "%{$degree}%");
            });
        });
    }
}
