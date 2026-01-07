<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\hr2\Admin\SuccessorCandidateHr2;

class SuccessionPositionHr2 extends Model
{
    use HasFactory;

    protected $table = 'succession_positions_hr2';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'position_title',
        'branch_id',
        'criticality',
    ];

    // Relationship to candidates
    public function candidates()
    {
        return $this->hasMany(SuccessorCandidateHr2::class, 'branch_id', 'branch_id');
    }
}
