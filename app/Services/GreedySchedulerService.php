<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeAvailability;
use App\Models\Schedule;
use App\Models\SchedulingRule;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

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
            ->with(['specialization', 'employees'])
            ->orderBy('deadline', 'asc')
            ->get();

        if ($tasks->isEmpty()) {
            $result['message'] = 'Tidak ada tugas pending yang perlu dijadwalkan.';
            return $result;
        }

        $employeeCount = Employee::count();
        if ($employeeCount === 0) {
            $result['message'] = 'Tidak ada data karyawan di sistem. Silakan tambahkan karyawan terlebih dahulu.';
            return $result;
        }

        $hasAvailability = EmployeeAvailability::exists();
        if (!$hasAvailability) {
            $result['message'] = 'Data ketersediaan (availability) karyawan belum diatur. Silakan atur jadwal ketersediaan karyawan terlebih dahulu.';
            return $result;
        }

        Log::info('Greedy Scheduler Start', [
            'total_pending_tasks' => $tasks->count(),
            'tasks' => $tasks->map(fn($t) => [
                'id' => $t->id,
                'title' => $t->title,
                'specialization_id' => $t->specialization_id,
                'specialization_name' => $t->specialization?->name,
                'deadline' => $t->deadline,
                'assigned_employees_count' => $t->employees->count(),
            ])->toArray(),
        ]);

        foreach ($tasks as $task) {
            $assigned = false;
            $workDate = Carbon::today();
            $deadline = Carbon::parse($task->deadline);
            
            $skipReason = 'Tidak ada karyawan tersedia sebelum deadline';

            // Pre-check: Any employees with this specialization at all?
            $hasSpecialist = true;
            if ($task->specialization_id) {
                $hasSpecialist = Employee::whereHas('specializations', fn($q) => $q->where('specializations.id', $task->specialization_id))->exists();
            }
            
            if (!$hasSpecialist) {
                $skipReason = 'Tidak ada karyawan dengan spesialisasi: ' . ($task->specialization?->name ?? 'Unknown');
            } else {
                Log::info('Processing Task', [
                    'task_id' => $task->id,
                    'title' => $task->title,
                    'specialization_id' => $task->specialization_id,
                ]);

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
                
                if (!$assigned && $workDate->gt($deadline)) {
                    // Check if anyone even has availability entries
                    $anyAvailability = EmployeeAvailability::exists();
                    if (!$anyAvailability) {
                        $skipReason = 'Data ketersediaan karyawan belum diatur di sistem';
                    }
                }
            }

            if (! $assigned) {
                $result['skipped']++;
                $result['details'][] = [
                    'task' => $task->title,
                    'reason' => $skipReason,
                ];
            }
        }

        return $result;
    }

    private function getCandidates(Task $task, Carbon $workDate, int $dayOfWeek): Collection
    {
        $weekStart = $workDate->copy()->startOfWeek()->toDateString();

        Log::info('getCandidates called', [
            'task_id' => $task->id,
            'task_title' => $task->title,
            'specialization_id' => $task->specialization_id,
            'work_date' => $workDate->toDateString(),
            'day_of_week' => $dayOfWeek,
        ]);

        $query = Employee::with(['user', 'specializations', 'availability', 'schedules'])
            ->whereHas('availability', fn ($query) => $query->where('day_of_week', $dayOfWeek));

        if ($task->specialization_id) {
            $query->whereHas('specializations', fn ($query) => $query->where('specializations.id', $task->specialization_id));
        }

        $employees = $query->get();

        Log::info('Base employees after availability + specialization filter', [
            'count' => $employees->count(),
            'employees' => $employees->map(fn($e) => [
                'id' => $e->id,
                'name' => $e->user?->name,
                'specialization_ids' => $e->specializations->pluck('id')->toArray(),
                'availability_days' => $e->availability->pluck('day_of_week')->toArray(),
            ])->toArray(),
        ]);

        $filtered = $employees->filter(function (Employee $employee) use ($weekStart, $workDate) {
            $dailyTasks = $employee->schedules
                ->where('work_date', $workDate->toDateString())
                ->whereNotNull('task_id')
                ->count();

            $weeklyHours = $this->getWeeklyHours($employee, $weekStart);

            $passed = $dailyTasks < $this->rules->max_tasks_per_day
                && $weeklyHours < $this->rules->max_hours_per_week;

            if (!$passed) {
                Log::info('Employee filtered out', [
                    'employee_id' => $employee->id,
                    'name' => $employee->user?->name,
                    'daily_tasks' => $dailyTasks,
                    'max_daily' => $this->rules->max_tasks_per_day,
                    'weekly_hours' => $weeklyHours,
                    'max_weekly' => $this->rules->max_hours_per_week,
                ]);
            }

            return $passed;
        });

        Log::info('Final candidates after capacity filter', [
            'count' => $filtered->count(),
            'employees' => $filtered->pluck('user.name')->toArray(),
        ]);

        return $filtered;
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
