<?php

namespace App\Models\Hr2;

use Illuminate\Database\Eloquent\Model;
use App\Models\hr2\CourseEnroll; // <-- import this

class Course extends Model
{
    protected $table = 'courses_hr2';

    // Relationship to enrollments
    public function enrolls()
    {
        return $this->hasMany(CourseEnroll::class, 'course_id', 'id');
    }
}
