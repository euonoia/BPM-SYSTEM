<?php

namespace App\Models\HR2\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminDashboardController extends Model
{
    protected $table = 'employees_hr2'; // Using _hr2 tables
    protected $primaryKey = 'employee_id';
    public $timestamps = false; // Add true if updated_at/created_at exist

    protected $fillable = [
        'first_name', 'last_name', 'email', 'role', 'position', 'branch', 'hire_date', 'password'
    ];
}
