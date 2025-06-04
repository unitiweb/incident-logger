<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncidentReportResource;
use App\Models\Department;
use App\Models\IncidentReport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IncidentReportController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, Department $department): AnonymousResourceCollection
    {
        $this->authorize('viewAny', $department);

        $perPage = $request->input('per_page', 30);

        $reports = IncidentReport::with(['department', 'incident'])
            ->where('department_id', $department->getKey())
            ->paginate($perPage);

        return IncidentReportResource::collection($reports);
    }
}
