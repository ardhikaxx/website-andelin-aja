<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Employee;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = Employee::with(['user', 'specializations'])->latest()->paginate(10);

        return view('admin.employees.index', compact('employees'));
    }

    public function create(): View
    {
        $specializations = Specialization::orderBy('name')->get();

        return view('admin.employees.create', compact('specializations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:pengawas_1,pengawas_2,senior_team,junior_team',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(storage_path('photos'), $filename);
            $photoPath = 'photos/' . $filename;
        }

        DB::transaction(function () use ($validated, $photoPath) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'phone' => $validated['phone'] ?? null,
                'role' => 'karyawan',
            ]);

            $employee = Employee::create([
                'user_id' => $user->id,
                'position' => $validated['position'],
                'photo' => $photoPath,
            ]);

            $employee->specializations()->sync($validated['specializations'] ?? []);

            AdminLog::create([
                'admin_id' => auth()->id(),
                'action' => 'EMPLOYEE_CREATE',
                'description' => "Menambahkan karyawan {$user->name}",
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Employee $employee): View
    {
        $employee->load(['user', 'specializations', 'tasks', 'schedules.task']);

        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $employee->load(['user', 'specializations']);
        $specializations = Specialization::orderBy('name')->get();

        return view('admin.employees.edit', compact('employee', 'specializations'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:pengawas_1,pengawas_2,senior_team,junior_team',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_photo' => 'nullable|boolean',
            'specializations' => 'nullable|array',
            'specializations.*' => 'exists:specializations,id',
        ]);

        $photoPath = $employee->photo;
        
        if ($request->boolean('remove_photo') && $photoPath) {
            if (file_exists(storage_path($photoPath))) {
                unlink(storage_path($photoPath));
            }
            $photoPath = null;
        } elseif ($request->hasFile('photo')) {
            if ($photoPath && file_exists(storage_path($photoPath))) {
                unlink(storage_path($photoPath));
            }
            $photo = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(storage_path('photos'), $filename);
            $photoPath = 'photos/' . $filename;
        }

        DB::transaction(function () use ($validated, $employee, $photoPath) {
            $employee->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => ($validated['password'] ?? null) ?: $employee->user->password,
            ]);

            $employee->update([
                'position' => $validated['position'],
                'photo' => $photoPath,
            ]);
            $employee->specializations()->sync($validated['specializations'] ?? []);

            AdminLog::create([
                'admin_id' => auth()->id(),
                'action' => 'EMPLOYEE_UPDATE',
                'description' => "Memperbarui karyawan {$employee->user->name}",
            ]);
        });

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $name = $employee->user->name;
        $employee->user()->delete();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'EMPLOYEE_DELETE',
            'description' => "Menghapus karyawan {$name}",
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
