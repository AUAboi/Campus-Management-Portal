<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function program()
    {
        return  $this->belongsTo(Program::class);
    }

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class);
    }
}
