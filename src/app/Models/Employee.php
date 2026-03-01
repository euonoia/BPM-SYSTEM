<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'contact_number',
        'email',
        'address',
        'department',
        'position',
        'job_grade',
        'employment_type',
        'date_hired',
        'basic_salary',
        'password',
        'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'birth_date' => 'date',
        'date_hired' => 'date',
        'basic_salary' => 'decimal:2'
    ];

    public function payrollRecords()
    {
        return $this->hasMany(PayrollRecord::class, 'employee_id', 'id');
    }

    public function compensationAdjustments()
    {
        return $this->hasMany(CompensationAdjustment::class, 'employee_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getYearsInPositionAttribute()
    {
        return $this->date_hired ? now()->diffInYears($this->date_hired) : 0;
    }

    public function scopeActive($query)
    {
        return $query->where('employment_type', '!=', 'terminated');
    }
}