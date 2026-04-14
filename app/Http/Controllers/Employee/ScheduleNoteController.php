<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ScheduleNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleNoteController extends Controller
{
    public function index(): JsonResponse
    {
        $employeeId = auth()->user()->employee->id;
        $notes = ScheduleNote::where('employee_id', $employeeId)
            ->orderBy('note_date', 'desc')
            ->get()
            ->map(function ($note) {
                return [
                    'id' => $note->id,
                    'title' => $note->title,
                    'description' => $note->description,
                    'note_date' => $note->note_date->format('Y-m-d'),
                    'note_date_formatted' => $note->note_date->format('d F Y'),
                ];
            });

        return response()->json($notes);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'note_date' => 'required|date',
        ]);

        $employeeId = auth()->user()->employee->id;
        
        $note = ScheduleNote::create([
            'employee_id' => $employeeId,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'note_date' => $validated['note_date'],
        ]);

        return response()->json([
            'message' => 'Catatan berhasil disimpan',
            'note' => [
                'id' => $note->id,
                'title' => $note->title,
                'description' => $note->description,
                'note_date' => $note->note_date->format('Y-m-d'),
                'note_date_formatted' => $note->note_date->format('d F Y'),
            ],
        ], 201);
    }

    public function show(ScheduleNote $note): JsonResponse
    {
        $this->authorizeAccess($note);

        return response()->json([
            'id' => $note->id,
            'title' => $note->title,
            'description' => $note->description,
            'note_date' => $note->note_date->format('Y-m-d'),
            'note_date_formatted' => $note->note_date->format('d F Y'),
        ]);
    }

    public function update(Request $request, ScheduleNote $note): JsonResponse
    {
        $this->authorizeAccess($note);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'note_date' => 'required|date',
        ]);

        $note->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'note_date' => $validated['note_date'],
        ]);

        return response()->json([
            'message' => 'Catatan berhasil diperbarui',
            'note' => [
                'id' => $note->id,
                'title' => $note->title,
                'description' => $note->description,
                'note_date' => $note->note_date->format('Y-m-d'),
                'note_date_formatted' => $note->note_date->format('d F Y'),
            ],
        ]);
    }

    public function destroy(ScheduleNote $note): JsonResponse
    {
        $this->authorizeAccess($note);
        $note->delete();

        return response()->json([
            'message' => 'Catatan berhasil dihapus',
        ]);
    }

    private function authorizeAccess(ScheduleNote $note): void
    {
        if ($note->employee_id !== auth()->user()->employee->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
