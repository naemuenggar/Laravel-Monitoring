<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function index(Request $request): Response
    {
        $reports = Report::query()
            ->when($request->search, fn ($query, $search) => $query->where('title', 'like', "%{$search}%"))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->from, fn ($query, $from) => $query->whereDate('created_at', '>=', $from))
            ->when($request->to, fn ($query, $to) => $query->whereDate('created_at', '<=', $to))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'total' => Report::count(),
            'completed' => Report::where('status', 'completed')->count(),
            'pending' => Report::where('status', 'pending')->count(),
            'failed' => Report::where('status', 'failed')->count(),
        ];

        $byType = Report::selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        return Inertia::render('Reports/Index', [
            'reports' => $reports,
            'filters' => $request->only(['search', 'status', 'from', 'to']),
            'summary' => $summary,
            'typeChart' => [
                'labels' => $byType->keys(),
                'data' => $byType->values(),
            ],
        ]);
    }
}
