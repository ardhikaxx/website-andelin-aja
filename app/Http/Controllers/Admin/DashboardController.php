<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Specialization;
use App\Models\Task;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'employees' => Employee::count(),
            'active_tasks' => Task::where('status', '!=', 'done')->count(),
            'greedy_schedules' => Schedule::where('generated_by', 'greedy')->count(),
            'specializations' => Specialization::count(),
        ];

        $recentTasks = Task::with('employees.user')->latest()->take(10)->get();

        return view('admin.dashboard.index', compact('stats', 'recentTasks'));
    }
}
