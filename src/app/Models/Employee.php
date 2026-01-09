<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Employee extends Authenticatable
{
    use Notifiable;

    /**
     * Legacy table (HR only for now)
     * Will later expand to logistics / financials
     */
    protected $table = 'employees_hr2';

    protected $primaryKey = 'id';

    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'name',
        'email',
        'phone',
        'password',

        // Access control
        'role', // hr | employee | admin

        // HR metadata
        'position',
        'branch',
        'hire_date',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Booted: ID + Timestamps
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::creating(function ($employee) {
            if (empty($employee->employee_id)) {
                $employee->employee_id = sprintf(
                    'EMP-%s-%s',
                    date('Y'),
                    strtoupper(substr(md5(uniqid()), 0, 6))
                );
            }

            $now = Carbon::now('UTC');
            $employee->created_at ??= $now;
            $employee->updated_at ??= $now;

            $employee->status ??= 'active';
            $employee->role ??= 'employee'; // default role if missing
        });

        static::updating(function ($employee) {
            $employee->updated_at = Carbon::now('UTC');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors (App Timezone)
    |--------------------------------------------------------------------------
    */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(config('app.timezone'));
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(config('app.timezone'));
    }

    /*
    |--------------------------------------------------------------------------
    | Authorization Helpers (Role-based)
    |--------------------------------------------------------------------------
    */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isHr(): bool
    {
        return $this->role === 'hr';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }
}
