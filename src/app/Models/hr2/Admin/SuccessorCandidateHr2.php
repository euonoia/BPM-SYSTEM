<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hr2\Admin\SuccessionPositionHr2;
use App\Models\Authenticate;
class SuccessorCandidateHr2 extends Model
{
    use HasFactory;

    protected $table = 'successor_candidates_hr2';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'branch_id',
        'employee_id',
        'readiness',
        'effective_at',
        'development_plan',
    ];

    public function position()
    {
        return $this->belongsTo(SuccessionPositionHr2::class, 'branch_id', 'branch_id');
    }

    public function employee()
    {
        return $this->belongsTo(Authenticate::class, 'employee_id', 'employee_id');
    }
}
