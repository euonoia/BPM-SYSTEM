<?php

namespace App\Models\Hr2;

use Illuminate\Database\Eloquent\Model;
use App\Models\hr2\CourseEnroll; 

class Course extends Model
{
    protected $table = 'courses_hr2';

    protected $primaryKey = 'course_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'course_id',
        'title',
        'created_at'
    ];

    public function getRouteKeyName(): string
    {
        return 'course_id';
    }

    public function enrolls()
    {
        return $this->hasMany(
            CourseEnroll::class,
            'course_id',
            'course_id'
        );
    }
}
