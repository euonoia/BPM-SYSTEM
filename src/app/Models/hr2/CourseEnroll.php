<?php

namespace App\Models\Hr2;

use Illuminate\Database\Eloquent\Model;

class CourseEnroll extends Model
{
    protected $table = 'course_enrolls_hr2';

    protected $fillable = [
        'id',
        'course_id',
        'employee_id',
        'enrolled_at',
    ];

    public $timestamps = false;
}
