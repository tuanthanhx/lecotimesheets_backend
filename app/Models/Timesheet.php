<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'job_id',
        'payroll_id',
        'note',
        'status',
        'hourly_rate',
        'date',
        'start_time',
        'end_time',
        'break',
    ];

    protected $casts = [
        'status' => 'integer',
        'hourly_rate' => 'float',
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Job relationship
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // Payroll relationship
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

}
