<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\SchedulingRule;
use App\Services\GreedySchedulerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchedulingController extends Controller
{
    public function index(Request $request): View
    {
        $rules = SchedulingRule::first();
        $employees = Employee::with('user')->get();
        $schedules = Schedule::with(['employee.user', 'task'])
            ->when($request->filled('work_date'), fn ($query) => $query->whereDate('work_date', $request->work_date))
            ->when($request->filled('employee_id'), fn ($query) => $query->where('employee_id', $request->employee_id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('generated_by'), fn ($query) => $query->where('generated_by', $request->generated_by))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.scheduling.index', compact('rules', 'schedules', 'employees'));
    }

    public function generate(): JsonResponse
    {
        $service = new GreedySchedulerService();
        $result = $service->generate();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'GREEDY_GENERATE',
            'description' => "Dijadwalkan: {$result['scheduled']} tugas, Dilewati: {$result['skipped']} tugas",
        ]);

        return response()->json($result);
    }

    public function updateRules(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'max_hours_per_week' => 'required|integer|min:1|max:168',
            'max_tasks_per_day' => 'required|integer|min:1|max:24',
        ]);

        SchedulingRule::updateOrCreate([], $validated);

        return back()->with('success', 'Aturan penjadwalan berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $taskTitle = $schedule->task?->title;
        if ($schedule->task) {
            $schedule->task->update(['status' => 'pending']);
        }

        $schedule->delete();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'SCHEDULE_DELETE',
            'description' => 'Menghapus jadwal ' . ($taskTitle ?: 'manual'),
        ]);

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}
