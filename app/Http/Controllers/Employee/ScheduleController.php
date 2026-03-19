<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(): View
    {
        return view('employee.schedule.index');
    }

    public function events(): JsonResponse
    {
        $empId = auth()->user()->employee->id;
        $schedules = Schedule::where('employee_id', $empId)
            ->with('task')
            ->get()
            ->map(fn ($schedule) => [
                'title' => $schedule->task?->title ?? 'Jadwal Kerja',
                'start' => $schedule->work_date->toDateString(),
                'extendedProps' => [
                    'time' => "{$schedule->start_time} - {$schedule->end_time}",
                    'status' => $schedule->status,
                ],
            ]);

        return response()->json($schedules);
    }
}
