<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = auth()->user()->employee->tasks()->latest()->get();

        return view('employee.tasks.index', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task): JsonResponse|RedirectResponse
    {
        abort_unless(
            auth()->user()->employee->tasks()->where('tasks.id', $task->id)->exists(),
            403,
            'Tugas tidak ditemukan.'
        );

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,done',
        ]);

        $task->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status tugas berhasil diperbarui.']);
    }
}
