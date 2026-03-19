<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Schedule;
use App\Models\SchedulingRule;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GreedySchedulerService
{
    private SchedulingRule $rules;

    public function __construct()
    {
        $this->rules = SchedulingRule::firstOrCreate([], [
            'max_hours_per_week' => 40,
            'max_tasks_per_day' => 3,
        ]);
    }

    public function generate(): array
    {
        $result = ['scheduled' => 0, 'skipped' => 0, 'details' => []];

        $tasks = Task::where('status', 'pending')
            ->orderBy('deadline', 'asc')
            ->get();

        foreach ($tasks as $task) {
            $assigned = false;
            $workDate = Carbon::today();
            $deadline = Carbon::parse($task->deadline);

            while ($workDate->lte($deadline)) {
                $dayOfWeek = $workDate->dayOfWeekIso;
                $candidates = $this->getCandidates($task, $workDate, $dayOfWeek);

                if ($candidates->isNotEmpty()) {
                    $bestEmployee = $this->selectLightestEmployee($candidates, $workDate);
                    $availability = $bestEmployee->availability
                        ->where('day_of_week', $dayOfWeek)
                        ->first();

                    Schedule::create([
                        'employee_id' => $bestEmployee->id,
                        'task_id' => $task->id,
                        'work_date' => $workDate->toDateString(),
                        'start_time' => $availability->start_time,
                        'end_time' => $availability->end_time,
                        'status' => 'scheduled',
                        'generated_by' => 'greedy',
                    ]);

                    $task->update(['status' => 'in_progress']);

                    $result['scheduled']++;
                    $result['details'][] = [
                        'task' => $task->title,
                        'employee' => $bestEmployee->user->name,
                        'date' => $workDate->format('d/m/Y'),
                    ];

                    $assigned = true;
                    break;
                }

                $workDate->addDay();
            }

            if (! $assigned) {
                $result['skipped']++;
                $result['details'][] = [
                    'task' => $task->title,
                    'reason' => 'Tidak ada karyawan tersedia sebelum deadline',
                ];
            }
        }

        return $result;
    }

    private function getCandidates(Task $task, Carbon $workDate, int $dayOfWeek): Collection
    {
        $weekStart = $workDate->copy()->startOfWeek()->toDateString();

        return Employee::with(['user', 'specializations', 'availability', 'schedules'])
            ->whereHas('availability', fn ($query) => $query->where('day_of_week', $dayOfWeek))
            ->get()
            ->filter(function (Employee $employee) use ($weekStart, $workDate) {
                $dailyTasks = $employee->schedules
                    ->where('work_date', $workDate->toDateString())
                    ->whereNotNull('task_id')
                    ->count();

                return $dailyTasks < $this->rules->max_tasks_per_day
                    && $this->getWeeklyHours($employee, $weekStart) < $this->rules->max_hours_per_week;
            });
    }

    private function selectLightestEmployee(Collection $candidates, Carbon $workDate): Employee
    {
        $weekStart = $workDate->copy()->startOfWeek()->toDateString();

        return $candidates->sortBy(
            fn (Employee $employee) => $this->getWeeklyHours($employee, $weekStart)
        )->first();
    }

    private function getWeeklyHours(Employee $employee, string $weekStart): float
    {
        $weekEnd = Carbon::parse($weekStart)->endOfWeek()->toDateString();

        return $employee->schedules
            ->whereBetween('work_date', [$weekStart, $weekEnd])
            ->sum(function (Schedule $schedule) {
                return Carbon::parse($schedule->start_time)
                    ->diffInHours(Carbon::parse($schedule->end_time));
            });
    }
}
