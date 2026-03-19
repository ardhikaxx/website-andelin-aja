<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\Request as EmployeeRequest;
use App\Models\ShiftSwap;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(): View
    {
        $requests = EmployeeRequest::with(['employee.user', 'fromSchedule.task', 'toEmployee.user', 'shiftSwap'])
            ->latest()
            ->paginate(10);

        return view('admin.requests.index', compact('requests'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('admin.requests.index');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('admin.requests.index');
    }

    public function show(EmployeeRequest $request): View
    {
        $request->load(['employee.user', 'fromSchedule.task', 'toEmployee.user', 'shiftSwap.schedule.task']);

        return view('admin.requests.show', ['item' => $request]);
    }

    public function edit(EmployeeRequest $request): RedirectResponse
    {
        return redirect()->route('admin.requests.show', $request);
    }

    public function update(Request $httpRequest, EmployeeRequest $request): RedirectResponse
    {
        return redirect()->route('admin.requests.show', $request);
    }

    public function destroy(EmployeeRequest $request): RedirectResponse
    {
        $request->delete();

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'REQUEST_DELETE',
            'description' => 'Menghapus pengajuan karyawan',
        ]);

        return back()->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function approve(EmployeeRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $request->update(['status' => 'approved']);

            if ($request->type === 'tukar_jadwal' && $request->fromSchedule && $request->to_employee_id) {
                $request->fromSchedule->update([
                    'employee_id' => $request->to_employee_id,
                    'generated_by' => 'manual',
                ]);

                ShiftSwap::firstOrCreate([
                    'request_id' => $request->id,
                ], [
                    'from_employee_id' => $request->employee_id,
                    'to_employee_id' => $request->to_employee_id,
                    'schedule_id' => $request->from_schedule_id,
                ]);
            }

            AdminLog::create([
                'admin_id' => auth()->id(),
                'action' => 'REQUEST_APPROVE',
                'description' => 'Menyetujui pengajuan karyawan',
            ]);
        });

        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(EmployeeRequest $request): RedirectResponse
    {
        $request->update(['status' => 'rejected']);

        AdminLog::create([
            'admin_id' => auth()->id(),
            'action' => 'REQUEST_REJECT',
            'description' => 'Menolak pengajuan karyawan',
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }
}
