<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompensationAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'current_grade',
        'current_salary',
        'proposed_grade',
        'proposed_salary',
        'performance_rating',
        'kpi_achievement',
        'attendance_score',
        'special_achievements',
        'promotion_raise',
        'performance_bonus',
        'kpi_incentive',
        'longevity_bonus',
        'total_increase',
        'increase_percentage',
        'status',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'current_salary' => 'decimal:2',
        'proposed_salary' => 'decimal:2',
        'performance_rating' => 'integer',
        'kpi_achievement' => 'decimal:2',
        'attendance_score' => 'decimal:2',
        'promotion_raise' => 'decimal:2',
        'performance_bonus' => 'decimal:2',
        'kpi_incentive' => 'decimal:2',
        'longevity_bonus' => 'decimal:2',
        'total_increase' => 'decimal:2',
        'increase_percentage' => 'decimal:2',
        'approved_at' => 'datetime'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function calculateTotal()
    {
        $this->total_increase = $this->promotion_raise 
                              + $this->performance_bonus 
                              + $this->kpi_incentive 
                              + $this->longevity_bonus;
        
        $this->proposed_salary = $this->current_salary + $this->total_increase;
        $this->increase_percentage = ($this->total_increase / $this->current_salary) * 100;
        
        return $this->total_increase;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}