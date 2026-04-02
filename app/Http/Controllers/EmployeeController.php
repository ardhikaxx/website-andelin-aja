<?php

namespace App\Http\Controllers;

use App\Models\Employee; // Assuming Employee model exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View; // Import View facade if needed for view compilation

class EmployeeController extends Controller
{
    /**
     * Display the welcome page with employee data.
     *
     * @return \Illuminate\View\View
     */
    public function showEmployees()
    {
        // Fetch all employees from the database
        $employees = Employee::all();

        // Return the welcome view, passing the employee data
        // The welcome.blade.php file will need to be updated to display this data.
        return view('welcome', compact('employees'));
    }
}
