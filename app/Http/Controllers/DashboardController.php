<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\MonitoringData;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'users' => User::count(),
            'products' => MonitoringData::count(),
            'reports' => Report::count(),
            'active' => MonitoringData::where('status', 'active')->count(),
        ];

        // Monthly line chart: monitoring data created per month (current year).
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $month->format('M');
            $monthlyData[] = MonitoringData::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Bar chart: count grouped by category.
        $categories = MonitoringData::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        $recentActivities = Activity::with('user')
            ->latest()
            ->take(8)
            ->get()
            ->map(fn ($activity) => [
                'id' => $activity->id,
                'user' => $activity->user?->name ?? 'System',
                'description' => $activity->description,
                'type' => $activity->type,
                'created_at' => $activity->created_at->diffForHumans(),
            ]);

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'lineChart' => [
                'labels' => $monthlyLabels,
                'data' => $monthlyData,
            ],
            'barChart' => [
                'labels' => $categories->keys(),
                'data' => $categories->values(),
            ],
            'recentActivities' => $recentActivities,
        ]);
    }
}
