<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'task_id', 'work_date', 'start_time', 'end_time', 'status', 'generated_by'];

    protected $casts = ['work_date' => 'date'];

    protected $appends = ['duration'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function getDurationAttribute(): float
    {
        return Carbon::parse($this->start_time)->diffInHours(Carbon::parse($this->end_time));
    }
}
