<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetencyHr2 extends Model
{
    use HasFactory;

    protected $table = 'competencies_hr2'; 

    protected $fillable = [
        'code',
        'title',
        'description',
        'competency_group',
    ];
}
