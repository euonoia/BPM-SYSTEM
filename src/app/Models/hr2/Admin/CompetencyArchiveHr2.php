<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetencyArchive extends Model
{
    use HasFactory;

    protected $table = 'competencies_archive_hr2';

    protected $fillable = [
        'code',
        'title',
        'description',
        'competency_group',
        'created_at',
    ];

    public $timestamps = false; // since we copy created_at manually
}
