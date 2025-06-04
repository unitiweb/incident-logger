<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class IncidentReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'data' => Arr::except($this->data, ['department']),
            'status' => $this->status,
            'processed_at' => $this->processed_at,
            'incident' => new IncidentResource($this->whenLoaded('incident')),
            'department' => new DepartmentResource($this->whenLoaded('department')),
        ];
    }
}
