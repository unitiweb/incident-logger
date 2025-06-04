<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class IncidentResource extends JsonResource
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
            'data' => Arr::except($this->raw_input_data, ['department']),
            'status' => $this->status,
            'timestamp' => $this->timestamp,
            'department' => new DepartmentResource($this->whenLoaded('department')),
        ];
    }
}
