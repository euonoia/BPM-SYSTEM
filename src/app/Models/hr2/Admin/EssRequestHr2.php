<?php

namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Authenticate;

class EssRequestHr2 extends Model
{
    use HasFactory;

    protected $table = 'ess_request_hr2';
    protected $primaryKey = 'id';
    public $timestamps = true; // assuming you have created_at / updated_at

    protected $fillable = [
        'employee_id',
        'type',
        'details',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(\App\Models\Authenticate::class, 'employee_id', 'employee_id');
    }

    // Archive request
    public function archive()
    {
        \DB::table('ess_request_archive')->insert([
            'ess_id' => $this->id,
            'employee_id' => $this->employee_id,
            'type' => $this->type,
            'details' => $this->details,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'archived_at' => now(),
        ]);

        $this->delete();
    }
}
