<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Request as EmployeeRequest;
use App\Models\Schedule;
use App\Models\ShiftSwap;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RequestSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::with(['user', 'schedules'])->get();

        $this->seedLeaveRequests($employees);
        $this->seedShiftSwapRequests($employees);
    }

    private function seedLeaveRequests($employees): void
    {
        $leaveReasons = [
            'Mengajukan cuti keluarga.',
            'Keperluan pribadi di luar kota.',
            'Pemulihan kondisi kesehatan.',
            'Menghadiri acara keluarga penting.',
            'Kebutuhan administrasi dan dokumen.',
            'Izin istirahat setelah proyek lapangan.',
        ];

        foreach ($employees as $employee) {
            $requestCount = rand(2, 4);

            for ($i = 0; $i < $requestCount; $i++) {
                $startDate = Carbon::today()->addDays(rand(-20, 35));
                $endDate = $startDate->copy()->addDays(rand(1, 4));
                $status = ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])];

                EmployeeRequest::create([
                    'employee_id' => $employee->id,
                    'type' => 'cuti',
                    'description' => $leaveReasons[array_rand($leaveReasons)],
                    'start_date' => $startDate->toDateString(),
                    'end_date' => $endDate->toDateString(),
                    'status' => $status,
                    'created_at' => $startDate->copy()->subDays(rand(1, 7))->setTime(rand(8, 16), 0),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function seedShiftSwapRequests($employees): void
    {
        $swapReasons = [
            'Meminta tukar jadwal karena kebutuhan keluarga.',
            'Bentrok dengan agenda pribadi yang tidak bisa dipindahkan.',
            'Memerlukan penyesuaian shift untuk urusan kesehatan.',
            'Mengajukan tukar jadwal agar distribusi kerja lebih seimbang.',
            'Ada kebutuhan mendadak pada hari jadwal berjalan.',
        ];

        $candidateSchedules = Schedule::with('employee')
            ->whereNotNull('task_id')
            ->orderBy('work_date')
            ->get()
            ->groupBy('employee_id');

        foreach ($employees as $employee) {
            $ownSchedules = $candidateSchedules->get($employee->id, collect())->shuffle()->take(rand(1, 3));

            foreach ($ownSchedules as $schedule) {
                $coworker = $employees
                    ->where('id', '!=', $employee->id)
                    ->random();

                $status = ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])];
                $createdAt = Carbon::parse($schedule->work_date)->copy()->subDays(rand(1, 10))->setTime(rand(8, 16), 0);

                $request = EmployeeRequest::create([
                    'employee_id' => $employee->id,
                    'type' => 'tukar_jadwal',
                    'description' => $swapReasons[array_rand($swapReasons)],
                    'from_schedule_id' => $schedule->id,
                    'to_employee_id' => $coworker->id,
                    'status' => $status,
                    'created_at' => $createdAt,
                    'updated_at' => now(),
                ]);

                ShiftSwap::create([
                    'request_id' => $request->id,
                    'from_employee_id' => $employee->id,
                    'to_employee_id' => $coworker->id,
                    'schedule_id' => $schedule->id,
                ]);
            }
        }
    }
}