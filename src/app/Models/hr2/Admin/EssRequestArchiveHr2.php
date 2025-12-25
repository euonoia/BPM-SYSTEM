<?php
namespace App\Models\Hr2\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EssRequestArchiveHr2 extends Model
{
    use HasFactory;

    protected $table = 'ess_request_archive_hr2';
    public $timestamps = true;

    protected $fillable = [
        'ess_id',
        'employee_id',
        'type',
        'details',
        'status',
        'archived_at',
    ];
}

