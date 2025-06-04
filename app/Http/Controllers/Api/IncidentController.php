<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessIncidentJob;
use Illuminate\Http\Request;
use App\Models\Incident;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request): JsonResponse
    {
        $department = Auth::user();

        $incident = Incident::create([
            'department_id' => $department->getKey(),
            'raw_input_data' => $request->all(),
            'status' => 'pending',
            'timestamp' => now(),
        ]);

        ProcessIncidentJob::dispatch($incident)
            ->onQueue($department->priority_level ?? 'low');

        return response()->json([
            'message' => 'Incident logged',
            'incident_id' => $incident->getKey()
        ], 201);
    }
}
