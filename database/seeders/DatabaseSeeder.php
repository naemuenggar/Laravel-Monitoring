<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\MonitoringData;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default admin account.
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Dummy users.
        $roles = ['admin', 'editor', 'user'];
        $statuses = ['active', 'inactive'];
        $names = ['Budi Santoso', 'Siti Aminah', 'Andi Wijaya', 'Dewi Lestari', 'Rudi Hartono',
            'Maya Sari', 'Agus Setiawan', 'Putri Anggraini', 'Joko Susilo', 'Rina Marlina',
            'Fajar Nugroho', 'Lina Kusuma', 'Hendra Gunawan', 'Wati Suryani', 'Bayu Pratama'];

        foreach ($names as $i => $name) {
            User::create([
                'name' => $name,
                'email' => 'user'.($i + 1).'@example.com',
                'password' => Hash::make('password'),
                'role' => $roles[$i % count($roles)],
                'status' => $statuses[$i % count($statuses)],
                'email_verified_at' => now(),
            ]);
        }

        // Monitoring data / products.
        $categories = ['Hardware', 'Software', 'Network', 'Sensor', 'Server'];
        $dataStatuses = ['active', 'inactive', 'pending'];
        for ($i = 1; $i <= 40; $i++) {
            MonitoringData::create([
                'name' => 'Device '.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'category' => $categories[array_rand($categories)],
                'description' => 'Monitoring entry for unit '.$i.'. Tracks operational status and metrics.',
                'status' => $dataStatuses[array_rand($dataStatuses)],
                'quantity' => rand(1, 250),
                'date' => Carbon::now()->subDays(rand(0, 330)),
                'created_at' => Carbon::now()->subDays(rand(0, 330)),
            ]);
        }

        // Reports.
        $types = ['Daily', 'Weekly', 'Monthly', 'Incident', 'Performance'];
        $reportStatuses = ['completed', 'pending', 'failed'];
        for ($i = 1; $i <= 25; $i++) {
            Report::create([
                'title' => $types[array_rand($types)].' Report #'.$i,
                'type' => $types[array_rand($types)],
                'status' => $reportStatuses[array_rand($reportStatuses)],
                'created_at' => Carbon::now()->subDays(rand(0, 60)),
            ]);
        }

        // Activities.
        $activities = [
            ['Logged into the dashboard', 'info'],
            ['Created a new monitoring entry', 'success'],
            ['Updated user profile', 'info'],
            ['Generated a monthly report', 'success'],
            ['Deleted an inactive device', 'danger'],
            ['Changed account password', 'warning'],
            ['Exported report data', 'info'],
            ['Added a new user account', 'success'],
        ];
        foreach ($activities as $i => [$desc, $type]) {
            Activity::create([
                'user_id' => $admin->id,
                'description' => $desc,
                'type' => $type,
                'created_at' => Carbon::now()->subHours($i * 3),
            ]);
        }
    }
}
