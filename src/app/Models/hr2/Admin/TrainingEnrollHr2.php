<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hr2\Admin\TrainingSessionHr2;

class TrainingEnrollHr2 extends Model
{
    use HasFactory;

    protected $table = 'training_enrolls_hr2';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'training_id',
        'status',
    ];

    public function training()
    {
        return $this->belongsTo(TrainingSessionHr2::class, 'training_id', 'training_id');
    }
}
