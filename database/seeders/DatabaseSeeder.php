<?php

namespace Database\Seeders;

use App\Models\SchedulingRule;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@andelin.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        $specs = ['Konstruksi', 'Elektrikal', 'Plumbing', 'Finishing', 'Pengawasan'];
        foreach ($specs as $spec) {
            Specialization::firstOrCreate(['name' => $spec]);
        }

        SchedulingRule::firstOrCreate([], [
            'max_hours_per_week' => 40,
            'max_tasks_per_day' => 3,
        ]);

        $this->call([
            EmployeeSeeder::class,
            TaskSeeder::class,
            ScheduleSeeder::class,
            RequestSeeder::class,
        ]);
    }
}