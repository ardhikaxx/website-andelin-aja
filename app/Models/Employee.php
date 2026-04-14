<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'position', 'photo'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class, 'employee_specializations');
    }

public function tasks(): BelongsToMany
{
    return $this->belongsToMany(Task::class, 'task_assignments')->withPivot('assigned_at');
}

public function taskAssignments(): HasMany
{
    return $this->hasMany(TaskAssignment::class);
}

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function scheduleNotes(): HasMany
    {
        return $this->hasMany(ScheduleNote::class);
    }

    public function availability(): HasMany
    {
        return $this->hasMany(EmployeeAvailability::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    public function weeklyHours(string $weekStart): float
    {
        return $this->schedules()
            ->whereBetween('work_date', [$weekStart, now()->endOfWeek()->toDateString()])
            ->get()
            ->sum(fn (Schedule $schedule) => Carbon::parse($schedule->start_time)->diffInHours(Carbon::parse($schedule->end_time)));
    }
}
