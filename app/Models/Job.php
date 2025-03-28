<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'revenue', 'material_cost', 'detail', 'date'];

    protected $hidden = [
        'revenue',
        'material_cost',
    ];

    protected $casts = [
        'status' => 'integer',
        'date' => 'date',
        'revenue' => 'float',
        'material_cost' => 'float',
    ];

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
