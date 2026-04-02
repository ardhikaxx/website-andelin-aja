<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function showEmployees(): View
    {
        $employees = Employee::with('user', 'specializations')->get();
        return view('welcome', compact('employees'));
    }
}