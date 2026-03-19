<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Specialization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpecializationController extends Controller
{
    public function index(): View
    {
        $specializations = Specialization::withCount('employees')->orderBy('name')->paginate(10);

        return view('admin.specializations.index', compact('specializations'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('admin.specializations.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:specializations,name',
            'description' => 'nullable|string',
        ]);

        $specialization = Specialization::create($validated);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'SPECIALIZATION_CREATE',
            'description' => "Menambahkan spesialisasi {$specialization->name}",
        ]);

        return back()->with('success', 'Spesialisasi berhasil ditambahkan.');
    }

    public function show(Specialization $specialization): RedirectResponse
    {
        return redirect()->route('admin.specializations.index');
    }

    public function edit(Specialization $specialization): RedirectResponse
    {
        return redirect()->route('admin.specializations.index', ['edit' => $specialization->id]);
    }

    public function update(Request $request, Specialization $specialization): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:specializations,name,' . $specialization->id,
            'description' => 'nullable|string',
        ]);

        $specialization->update($validated);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'SPECIALIZATION_UPDATE',
            'description' => "Memperbarui spesialisasi {$specialization->name}",
        ]);

        return back()->with('success', 'Spesialisasi berhasil diperbarui.');
    }

    public function destroy(Specialization $specialization): RedirectResponse
    {
        $name = $specialization->name;
        $specialization->delete();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'SPECIALIZATION_DELETE',
            'description' => "Menghapus spesialisasi {$name}",
        ]);

        return back()->with('success', 'Spesialisasi berhasil dihapus.');
    }
}
