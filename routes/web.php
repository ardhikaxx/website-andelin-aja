<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Employee;
use App\Http\Controllers\EmployeeController; // Import EmployeeController
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

// Route for serving photos from storage
Route::get('/photos/{filename}', function ($filename) {
    $path = storage_path('photos/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    return response($file, 200)->header('Content-Type', $type);
})->where('filename', '.*');

// Route for the homepage that uses the EmployeeController to pass data
// Changed from Route::view to Route::get and specified controller method
Route::get('/', [EmployeeController::class, 'showEmployees'])->name('welcome'); // Changed name back to 'welcome' to match original

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'verifyForgotPassword'])->name('password.email');
Route::get('/reset-password', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'updateForgotPassword'])->name('password.update');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('employees', Admin\EmployeeController::class);
    Route::resource('specializations', Admin\SpecializationController::class);
    Route::resource('tasks', Admin\TaskController::class);
    Route::resource('assignments', Admin\AssignmentController::class);
    Route::resource('requests', Admin\RequestController::class);
    Route::resource('admins', Admin\AdminManagementController::class)->parameters(['admins' => 'admin']);

    Route::get('/scheduling', [Admin\SchedulingController::class, 'index'])->name('scheduling.index');
    Route::post('/scheduling/generate', [Admin\SchedulingController::class, 'generate'])->name('scheduling.generate');
    Route::put('/scheduling/rules', [Admin\SchedulingController::class, 'updateRules'])->name('scheduling.rules');
    Route::delete('/scheduling/{schedule}', [Admin\SchedulingController::class, 'destroy'])->name('scheduling.destroy');

    Route::patch('/requests/{request}/approve', [Admin\RequestController::class, 'approve'])->name('requests.approve');
    Route::patch('/requests/{request}/reject', [Admin\RequestController::class, 'reject'])->name('requests.reject');

    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [Admin\ReportController::class, 'export'])->name('reports.export');

    Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('employee')->name('employee.')->middleware(['auth', 'employee'])->group(function () {
    Route::get('/home', [Employee\HomeController::class, 'index'])->name('home');

    Route::get('/tasks', [Employee\TaskController::class, 'index'])->name('tasks.index');
    Route::patch('/tasks/{task}/status', [Employee\TaskController::class, 'updateStatus'])->name('tasks.status');

    Route::get('/schedule', [Employee\ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/events', [Employee\ScheduleController::class, 'events'])->name('schedule.events');

    Route::get('/requests', [Employee\RequestController::class, 'index'])->name('requests.index');
    Route::post('/requests', [Employee\RequestController::class, 'store'])->name('requests.store');

    Route::get('/profile', [Employee\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Employee\ProfileController::class, 'update'])->name('profile.update');
});
