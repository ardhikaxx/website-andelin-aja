<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $month = (int) ($request->month ?: now()->month);
        $year = (int) ($request->year ?: now()->year);
        $employees = Employee::with('user')->get();

        $reports = $employees
            ->when($request->filled('employee_id'), fn ($collection) => $collection->where('id', (int) $request->employee_id))
            ->map(function (Employee $employee) use ($month, $year) {
                $schedules = $employee->schedules()
                    ->whereMonth('work_date', $month)
                    ->whereYear('work_date', $year)
                    ->get();

                $report = Report::updateOrCreate(
                    ['employee_id' => $employee->id, 'month' => $month, 'year' => $year],
                    [
                        'total_hours' => $schedules->sum('duration'),
                        'total_tasks' => $schedules->whereNotNull('task_id')->count(),
                    ]
                );

                return $report->load('employee.user');
            });

        return view('admin.reports.index', compact('reports', 'employees', 'month', 'year'));
    }

    public function export(Request $request): Response
    {
        $month = (int) ($request->month ?: now()->month);
        $year = (int) ($request->year ?: now()->year);
        $employeeId = $request->employee_id;

        $reports = Report::with('employee.user')
            ->where('month', $month)
            ->where('year', $year)
            ->when($employeeId, fn ($query) => $query->where('employee_id', $employeeId))
            ->get();

        $rows = ["Karyawan\tTotal Jam\tTotal Tugas"];
        foreach ($reports as $report) {
            $rows[] = implode("\t", [
                $report->employee->user->name,
                $report->total_hours,
                $report->total_tasks,
            ]);
        }

        return response(implode("\n", $rows), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan-andelin-' . $month . '-' . $year . '.xls"',
        ]);
    }
}
