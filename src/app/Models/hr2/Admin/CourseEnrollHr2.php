<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hr2\Admin\LearningModuleHr2;

class CourseEnrollHr2 extends Model
{
    use HasFactory;

    protected $table = 'course_enrolls_hr2';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'course_id',
        'status',
    ];

    // Relationship back to course
    public function course()
    {
        return $this->belongsTo(LearningModuleHr2::class, 'course_id', 'id');
    }
}
