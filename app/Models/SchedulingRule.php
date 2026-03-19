<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulingRule extends Model
{
    use HasFactory;

    protected $fillable = ['max_hours_per_week', 'max_tasks_per_day'];
}
