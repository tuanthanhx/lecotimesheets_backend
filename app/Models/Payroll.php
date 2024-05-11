<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'time_worked',
    ];

    protected $casts = [
        'amount' => 'float',
        'time_worked' => 'float',
    ];

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // User relationship
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
