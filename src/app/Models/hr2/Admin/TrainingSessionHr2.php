<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\hr2\Admin\TrainingEnrollHr2;

class TrainingSessionHr2 extends Model
{
    use HasFactory;

    protected $table = 'training_sessions_hr2';
    protected $primaryKey = 'id';
    public $timestamps = false; // no created_at / updated_at

    protected $fillable = [
        'training_id',
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'location',
        'trainer',
        'capacity',
    ];

    // Relationship to enrolls
    public function enrolls()
    {
        return $this->hasMany(TrainingEnrollHr2::class, 'training_id', 'training_id');
    }
}
