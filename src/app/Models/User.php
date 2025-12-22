<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

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
        'role',
        'position',
        'branch',
        'hire_date'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'hire_date' => 'date', // No timezone conversion needed
    ];

    /**
     * Booted method for automatic employee_id and UTC timestamps
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            // Auto-generate employee_id if empty
            if (empty($user->employee_id)) {
                $prefix = 'EMP';
                $year = date('Y');
                $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5));
                $user->employee_id = "{$prefix}-{$year}-{$random}";
            }

            // Ensure timestamps are in UTC
            $nowUtc = Carbon::now('UTC')->toDateTimeString();
            $user->created_at = $user->created_at ?? $nowUtc;
            $user->updated_at = $user->updated_at ?? $nowUtc;
        });

        static::updating(function ($user) {
            $user->updated_at = Carbon::now('UTC')->toDateTimeString();
        });
    }

    /**
     * Accessors to convert UTC timestamps to user/app timezone
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone(config('app.timezone'));
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone(config('app.timezone'));
    }
}
