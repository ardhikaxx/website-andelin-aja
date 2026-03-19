<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(): View
    {
        $tasks = Task::with(['employees.user'])->latest()->paginate(10);
        $employees = Employee::with('user')->orderBy('id')->get();

        return view('admin.assignments.index', compact('tasks', 'employees'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('admin.assignments.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        $task = Task::findOrFail($validated['task_id']);
        $syncData = collect($validated['employee_ids'])->mapWithKeys(fn ($id) => [$id => ['assigned_at' => now()]]);
        $task->employees()->sync($syncData->all());

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'ASSIGNMENT_UPDATE',
            'description' => "Memperbarui penugasan untuk {$task->title}",
        ]);

        return back()->with('success', 'Penugasan berhasil disimpan.');
    }

    public function show(Task $assignment): RedirectResponse
    {
        return redirect()->route('admin.assignments.index');
    }

    public function edit(Task $assignment): RedirectResponse
    {
        return redirect()->route('admin.assignments.index');
    }

    public function update(Request $request, Task $assignment): RedirectResponse
    {
        return $this->store($request);
    }

    public function destroy(Task $assignment): RedirectResponse
    {
        $assignment->employees()->detach();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'ASSIGNMENT_DELETE',
            'description' => "Menghapus penugasan untuk {$assignment->title}",
        ]);

        return back()->with('success', 'Penugasan berhasil dihapus.');
    }
}
