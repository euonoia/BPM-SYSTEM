<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriterion_hr1 extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria_hr1';

    protected $fillable = [
        'label',
        'section',
        'weight',
    ];
}

