<?php

namespace App\Gateways;

use App\Gateways\Support\IncidentGatewayBase;

class DefaultIncidentGateway extends IncidentGatewayBase
{
    public function cleanPayload(array $payload): array
    {
        $payload['_warning'] = 'Processed by default gateway. No specific behavior applied.';
        return $payload;
    }

    public function addMetadata(array $payload): array
    {
        $payload['processed_by'] = 'Default Gateway';
        return $payload;
    }
}
