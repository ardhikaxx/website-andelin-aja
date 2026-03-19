<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedTaskSchedules();
        $this->seedManualSchedules();
    }

    private function seedTaskSchedules(): void
    {
        $doneTasks = Task::with(['employees.availability'])
            ->where('status', 'done')
            ->get();

        foreach ($doneTasks as $task) {
            $employees = $task->employees->shuffle()->take(rand(1, min(2, max(1, $task->employees->count()))));

            foreach ($employees as $employee) {
                $workDate = $this->businessDay(Carbon::parse($task->deadline)->copy()->subDays(rand(1, 12)), false);
                $availability = $employee->availability->firstWhere('day_of_week', $workDate->dayOfWeekIso);

                if (! $availability) {
                    continue;
                }

                Schedule::create([
                    'employee_id' => $employee->id,
                    'task_id' => $task->id,
                    'work_date' => $workDate->toDateString(),
                    'start_time' => $availability->start_time,
                    'end_time' => $availability->end_time,
                    'status' => 'completed',
                    'generated_by' => rand(0, 1) ? 'greedy' : 'manual',
                ]);
            }
        }

        $progressTasks = Task::with(['employees.availability'])
            ->where('status', 'in_progress')
            ->get();

        foreach ($progressTasks as $task) {
            $employees = $task->employees->shuffle()->take(rand(1, min(2, max(1, $task->employees->count()))));
            $index = 0;

            foreach ($employees as $employee) {
                $baseDate = $index === 0
                    ? Carbon::today()->addDays(rand(0, 15))
                    : Carbon::today()->subDays(rand(1, 10));

                $workDate = $this->businessDay($baseDate, $index === 0);
                $availability = $employee->availability->firstWhere('day_of_week', $workDate->dayOfWeekIso);

                if (! $availability) {
                    continue;
                }

                Schedule::create([
                    'employee_id' => $employee->id,
                    'task_id' => $task->id,
                    'work_date' => $workDate->toDateString(),
                    'start_time' => $availability->start_time,
                    'end_time' => $availability->end_time,
                    'status' => $workDate->isFuture() || $workDate->isToday() ? 'scheduled' : 'completed',
                    'generated_by' => rand(0, 1) ? 'greedy' : 'manual',
                ]);

                $index++;
            }
        }
    }

    private function seedManualSchedules(): void
    {
        $employees = Employee::with('availability')->get();

        foreach ($employees as $employee) {
            for ($i = 0; $i < 12; $i++) {
                $workDate = $this->businessDay(Carbon::today()->subDays(20)->addDays(rand(0, 55)), true);
                $availability = $employee->availability->firstWhere('day_of_week', $workDate->dayOfWeekIso);

                if (! $availability) {
                    continue;
                }

                $exists = Schedule::query()
                    ->where('employee_id', $employee->id)
                    ->whereDate('work_date', $workDate->toDateString())
                    ->exists();

                if ($exists) {
                    continue;
                }

                Schedule::create([
                    'employee_id' => $employee->id,
                    'task_id' => null,
                    'work_date' => $workDate->toDateString(),
                    'start_time' => $availability->start_time,
                    'end_time' => $availability->end_time,
                    'status' => $workDate->isFuture() || $workDate->isToday() ? 'scheduled' : 'completed',
                    'generated_by' => 'manual',
                ]);
            }
        }
    }

    private function businessDay(Carbon $date, bool $forward): Carbon
    {
        $workDate = $date->copy();

        while ($workDate->dayOfWeekIso > 5) {
            $workDate = $forward ? $workDate->addDay() : $workDate->subDay();
        }

        return $workDate;
    }
}