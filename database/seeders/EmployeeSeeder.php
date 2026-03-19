<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeAvailability;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Karyawan {$i}",
                'email' => "karyawan{$i}@andelin.com",
                'password' => bcrypt('password'),
                'role' => 'karyawan',
            ]);

            $employee = Employee::create([
                'user_id' => $user->id,
                'position' => ['pengawas_1', 'pengawas_2', 'senior_team', 'junior_team'][rand(0, 3)],
            ]);

            $specIds = Specialization::query()->inRandomOrder()->take(rand(1, 3))->pluck('id');
            $employee->specializations()->attach($specIds);

            for ($day = 1; $day <= 5; $day++) {
                EmployeeAvailability::create([
                    'employee_id' => $employee->id,
                    'day_of_week' => $day,
                    'start_time' => '08:00',
                    'end_time' => '17:00',
                ]);
            }
        }
    }
}
