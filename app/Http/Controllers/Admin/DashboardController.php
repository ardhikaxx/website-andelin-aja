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
            'active_tasks' => Task::whereIn('status', ['pending', 'in_progress'])->count(),
            'greedy_schedules' => Schedule::query()
                ->where('generated_by', 'greedy')
                ->whereNotNull('task_id')
                ->distinct('task_id')
                ->count('task_id'),
            'specializations' => Specialization::count(),
        ];

        $recentTasks = Task::with('employees.user')
            ->latest()
            ->take(8)
            ->get();

        $performanceChart = [
            'labels' => ['Selesai', 'Sedang Berjalan', 'Tertunda'],
            'values' => [
                Task::where('status', 'done')->count(),
                Task::where('status', 'in_progress')->count(),
                Task::where('status', 'pending')->count(),
            ],
            'colors' => ['#22C55E', '#0EA5E9', '#F59E0B'],
        ];

        $performanceSummary = [
            [
                'label' => 'Selesai',
                'value' => $performanceChart['values'][0],
                'color' => '#22C55E',
                'description' => 'Tugas yang sudah dituntaskan oleh tim.',
            ],
            [
                'label' => 'Berjalan',
                'value' => $performanceChart['values'][1],
                'color' => '#0EA5E9',
                'description' => 'Tugas yang masih dikerjakan saat ini.',
            ],
            [
                'label' => 'Tertunda',
                'value' => $performanceChart['values'][2],
                'color' => '#F59E0B',
                'description' => 'Tugas yang menunggu eksekusi lanjutan.',
            ],
        ];

        return view('admin.dashboard.index', compact('stats', 'recentTasks', 'performanceChart', 'performanceSummary'));
    }
}