<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $employees = Employee::query()->get();

        $taskThemes = [
            'Inspeksi Lokasi',
            'Pengecekan Material',
            'Pemasangan Panel',
            'Perbaikan Pipa',
            'Finishing Area',
            'Audit Keselamatan',
            'Kalibrasi Mesin',
            'Pemeriksaan Struktur',
            'Instalasi Kabel',
            'Koordinasi Lapangan',
            'Validasi Kualitas',
            'Perawatan Harian',
        ];

        $areas = [
            'Zona A',
            'Zona B',
            'Gudang Utama',
            'Lantai 1',
            'Lantai 2',
            'Area Produksi',
            'Area Servis',
            'Ruang Kontrol',
            'Workshop',
            'Sektor Timur',
        ];

        for ($i = 1; $i <= 180; $i++) {
            $status = match (true) {
                $i <= 60 => 'done',
                $i <= 130 => 'in_progress',
                default => 'pending',
            };

            $deadline = match ($status) {
                'done' => Carbon::today()->subDays(rand(5, 60)),
                'in_progress' => Carbon::today()->addDays(rand(1, 25)),
                default => Carbon::today()->addDays(rand(10, 45)),
            };

            $title = $taskThemes[array_rand($taskThemes)] . ' ' . $areas[array_rand($areas)] . ' #' . str_pad((string) $i, 3, '0', STR_PAD_LEFT);

            $task = Task::create([
                'title' => $title,
                'description' => fake()->sentence(18),
                'deadline' => $deadline,
                'status' => $status,
                'created_by' => $admin->id,
            ]);

            $assignedEmployees = $employees->shuffle()->take(rand(1, min(3, $employees->count())));
            $syncData = $assignedEmployees->mapWithKeys(function (Employee $employee) use ($deadline) {
                return [
                    $employee->id => [
                        'assigned_at' => Carbon::parse($deadline)->copy()->subDays(rand(2, 14))->setTime(rand(8, 15), 0),
                    ],
                ];
            })->all();

            $task->employees()->sync($syncData);
        }
    }
}