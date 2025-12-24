<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\hr2\Admin\CourseEnrollHr2;

class LearningModuleHr2 extends Model
{
    use HasFactory;

    protected $table = 'learning_modules_hr2';
    protected $primaryKey = 'id';
    public $timestamps = false; // table has no created_at / updated_at

    protected $fillable = [
        'title',
        'description',
        'competency_id',
        'learning_type',
        'duration',
    ];

    // Relationship to enrolls
    public function enrolls()
    {
        return $this->hasMany(CourseEnrollHr2::class, 'course_id', 'id');
    }
}
