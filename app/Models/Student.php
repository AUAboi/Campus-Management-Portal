<?php

namespace App\Models;

use App\Models\User;
use Error;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_type',
        'registration_number',
        'roll_no',
        'admission_year',
        'program_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class)->orderBy('name', 'asc');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function enroll($program)
    {
        if ($this->program) {
            throw new Error('Student is already enrolled');
        }
        $this->update([
            'program_id' => $program,
            'admission_year' => now()->year
        ]);
    }

    public function getFullRegistrationNumber()
    {
        return "{$this->created_at->year}-rlaf-{$this->registration_number}";
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        });
    }
}
