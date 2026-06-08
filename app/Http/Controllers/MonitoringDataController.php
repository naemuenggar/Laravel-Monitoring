<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\MonitoringData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class MonitoringDataController extends Controller
{
    public function index(Request $request): Response
    {
        $data = MonitoringData::query()
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->when($request->category, fn ($query, $category) => $query->where('category', $category))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('MonitoringData/Index', [
            'items' => $data,
            'filters' => $request->only(['search', 'category', 'status']),
            'categories' => MonitoringData::distinct()->orderBy('category')->pluck('category'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('MonitoringData/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $item = MonitoringData::create($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => "Added monitoring data: {$item->name}",
            'type' => 'success',
        ]);

        return redirect()->route('monitoring-data.index')->with('success', 'Data created successfully.');
    }

    public function edit(MonitoringData $monitoringDatum): Response
    {
        return Inertia::render('MonitoringData/Edit', [
            'item' => $monitoringDatum,
        ]);
    }

    public function update(Request $request, MonitoringData $monitoringDatum): RedirectResponse
    {
        $validated = $this->validateData($request);

        $monitoringDatum->update($validated);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => "Updated monitoring data: {$monitoringDatum->name}",
            'type' => 'info',
        ]);

        return redirect()->route('monitoring-data.index')->with('success', 'Data updated successfully.');
    }

    public function destroy(Request $request, MonitoringData $monitoringDatum): RedirectResponse
    {
        $name = $monitoringDatum->name;
        $monitoringDatum->delete();

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => "Deleted monitoring data: {$name}",
            'type' => 'danger',
        ]);

        return redirect()->route('monitoring-data.index')->with('success', 'Data deleted successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])],
            'quantity' => ['required', 'integer', 'min:0'],
            'date' => ['required', 'date'],
        ]);
    }
}
