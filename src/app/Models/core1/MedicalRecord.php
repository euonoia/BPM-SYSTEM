<?php

namespace App\Models\core1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'record_type',
        'diagnosis',
        'treatment',
        'prescription',
        'notes',
        'record_date',
        'attachments',
    ];

    protected $casts = [
        'record_date' => 'datetime',
        'attachments' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(\App\Models\core1\User::class, 'doctor_id');
    }
}

