<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'revenue', 'material_cost', 'detail', 'date'];

    protected $casts = [
        'date' => 'date',
        'revenue' => 'decimal:2',
        'material_cost' => 'decimal:2',
    ];
}
