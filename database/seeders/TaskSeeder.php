<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Specialization;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $specializations = Specialization::all();

        if ($specializations->isEmpty()) {
            $this->command->error('No specializations found. Run EmployeeSeeder first.');
            return;
        }

        $taskThemes = [
            'Penulis' => [
                'Pembuatan Artikel',
                'Penulisan Konten',
                'Copywriting',
                'Editing Naskah',
                'Review Artikel',
            ],
            'Antar Jemput' => [
                'Pengiriman Paket',
                'Penjemputan Barang',
                'Distribusi Dokumen',
                'Antar Barang ke Client',
                'Logistik Harian',
            ],
            'Pembersih' => [
                'Pembersihan Gedung',
                'Sanitasi Area',
                'Kebersihan Lantai',
                'Pembersihan Gudang',
                'Perawatan Toilet',
            ],
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

        $taskCounter = 1;

        foreach ($specializations as $spec) {
            $themes = $taskThemes[$spec->name] ?? ['Tugas'];
            
            $tasksPerSpec = 60;
            
            for ($i = 1; $i <= $tasksPerSpec; $i++) {
                $status = match (true) {
                    $i <= 20 => 'done',
                    $i <= 45 => 'in_progress',
                    default => 'pending',
                };

                $deadline = match ($status) {
                    'done' => Carbon::today()->subDays(rand(5, 60)),
                    'in_progress' => Carbon::today()->addDays(rand(1, 25)),
                    default => Carbon::today()->addDays(rand(10, 45)),
                };

                $theme = $themes[array_rand($themes)];
                $area = $areas[array_rand($areas)];
                $title = "{$theme} - {$area} #" . str_pad((string) $taskCounter, 3, '0', STR_PAD_LEFT);

                $task = Task::create([
                    'title' => $title,
                    'description' => "Tugas {$spec->name}: " . fake()->sentence(15),
                    'deadline' => $deadline,
                    'status' => $status,
                    'specialization_id' => $spec->id,
                    'created_by' => $admin->id,
                ]);

                $qualifiedEmployees = Employee::whereHas('specializations', function ($query) use ($spec) {
                    $query->where('specializations.id', $spec->id);
                })->get();

                if ($qualifiedEmployees->isNotEmpty()) {
                    $assignedCount = min(rand(1, 3), $qualifiedEmployees->count());
                    $assignedEmployees = $qualifiedEmployees->shuffle()->take($assignedCount);
                    
                    $syncData = $assignedEmployees->mapWithKeys(function (Employee $employee) use ($deadline) {
                        return [
                            $employee->id => [
                                'assigned_at' => Carbon::parse($deadline)->copy()->subDays(rand(2, 14))->setTime(rand(8, 15), 0),
                            ],
                        ];
                    })->all();

                    $task->employees()->sync($syncData);
                }

                $taskCounter++;
            }
        }

        $totalTasks = $taskCounter - 1;
        $this->command->info("Created {$totalTasks} tasks assigned based on specializations!");
    }
}