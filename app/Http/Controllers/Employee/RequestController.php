<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Request as EmployeeRequest;
use App\Models\ShiftSwap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(): View
    {
        $employee = auth()->user()->employee;
        $requests = $employee->requests()->with(['fromSchedule.task', 'toEmployee.user'])->latest()->get();
        $schedules = $employee->schedules()->with('task')->orderByDesc('work_date')->get();
        $coworkers = Employee::with('user')->where('id', '!=', $employee->id)->get();

        return view('employee.requests.index', compact('requests', 'schedules', 'coworkers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:cuti,tukar_jadwal',
            'description' => 'required|string|max:500',
            'start_date' => 'nullable|required_if:type,cuti|date',
            'end_date' => 'nullable|required_if:type,cuti|date|after_or_equal:start_date',
            'from_schedule_id' => 'required_if:type,tukar_jadwal|exists:schedules,id',
            'to_employee_id' => 'required_if:type,tukar_jadwal|exists:employees,id',
        ]);

        DB::transaction(function () use ($validated) {
            $employee = auth()->user()->employee;

            $requestModel = EmployeeRequest::create([
                'employee_id' => $employee->id,
                'type' => $validated['type'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
                'from_schedule_id' => $validated['from_schedule_id'] ?? null,
                'to_employee_id' => $validated['to_employee_id'] ?? null,
            ]);

            if ($validated['type'] === 'tukar_jadwal') {
                ShiftSwap::create([
                    'request_id' => $requestModel->id,
                    'from_employee_id' => $employee->id,
                    'to_employee_id' => $validated['to_employee_id'],
                    'schedule_id' => $validated['from_schedule_id'],
                ]);
            }
        });

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }
}
