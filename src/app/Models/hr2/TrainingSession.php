<?php

namespace App\Models\Hr2;

use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    protected $table = 'training_sessions_hr2';
    protected $primaryKey = 'training_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
}
