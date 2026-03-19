<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $empId = auth()->user()->employee->id;
        $todaySchedules = Schedule::where('employee_id', $empId)
            ->whereDate('work_date', today())
            ->with('task')
            ->get();

        return view('employee.home.index', compact('todaySchedules'));
    }
}
