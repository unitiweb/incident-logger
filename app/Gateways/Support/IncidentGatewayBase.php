<?php

namespace App\Gateways\Support;

use App\Models\Department;

abstract class IncidentGatewayBase implements IncidentGatewayInterface
{
    public function __construct(protected Department $department)
    {
        // These aren’t the droids you’re looking for. Move along, move along.
    }

    protected function validateRequiredFields(array $payload, array $fields): void
    {
        foreach ($fields as $field) {
            if (empty($payload[$field])) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }
    }
}
