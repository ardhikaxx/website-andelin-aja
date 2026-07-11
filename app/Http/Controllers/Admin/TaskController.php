<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Specialization;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::with(['employees.user', 'creator'])->latest()->paginate(10);

        return view('admin.tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        $specializations = Specialization::orderBy('name')->get();

        return view('admin.tasks.create', compact('specializations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'deadline' => 'required|date|after_or_equal:today',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        $task = Task::create($validated + ['created_by' => auth()->id()]);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'TASK_CREATE',
            'description' => "Membuat tugas {$task->title}",
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Tugas berhasil dibuat.');
    }

    public function show(Task $task): View
    {
        $task->load(['employees.user', 'creator', 'schedules.employee.user']);

        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $specializations = Specialization::orderBy('name')->get();

        return view('admin.tasks.edit', compact('task', 'specializations'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,in_progress,done',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        $task->update($validated);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'TASK_UPDATE',
            'description' => "Memperbarui tugas {$task->title}",
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $title = $task->title;
        $task->delete();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'TASK_DELETE',
            'description' => "Menghapus tugas {$title}",
        ]);

        return redirect()->route('admin.tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
