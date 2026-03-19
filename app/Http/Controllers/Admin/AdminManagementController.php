<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminManagementController extends Controller
{
    public function index(): View
    {
        $admins = User::where('role', 'admin')->latest()->paginate(10);
        $logs = AdminLog::with('admin')->latest()->take(15)->get();

        return view('admin.admins.index', compact('admins', 'logs'));
    }

    public function create(): View
    {
        return view('admin.admins.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $admin = User::create($validated + ['role' => 'admin']);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'ADMIN_CREATE',
            'description' => "Menambahkan admin {$admin->name}",
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function show(User $admin): View
    {
        $logs = AdminLog::with('admin')->where('admin_id', $admin->id)->latest()->paginate(10);

        return view('admin.admins.show', compact('admin', 'logs'));
    }

    public function edit(User $admin): View
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $admin->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => ($validated['password'] ?? null) ?: $admin->password,
        ]);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'ADMIN_UPDATE',
            'description' => "Memperbarui admin {$admin->name}",
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $admin): RedirectResponse
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Admin aktif tidak dapat dihapus.');
        }

        $name = $admin->name;
        $admin->delete();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'ADMIN_DELETE',
            'description' => "Menghapus admin {$name}",
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dihapus.');
    }
}
