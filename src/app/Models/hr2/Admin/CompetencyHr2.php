<?php

namespace App\Models\hr2\Admin;

use Illuminate\Database\Eloquent\Model;

class CompetencyHr2 extends Model
{
    protected $table = 'competencies_hr2';

    public $timestamps = false;

    protected $fillable = [
        'code',
        'title',
        'description',
        'competency_group',
    ];
}
