<?php

namespace App\Gateways;

use App\Gateways\Support\IncidentGatewayBase;

/**
 * Sample Payload Gateway for Muggle Wipe
 *  {
 *      "event": "Memory Charm",
 *      "affected_muggles": 3,
 *      "location": "London Underground",
 *      "lead_wizard": "Arthur Weasley"
 *  }
 */
class MuggleWipeGateway extends IncidentGatewayBase
{
    public function cleanPayload(array $payload): array
    {
        $this->validateRequiredFields($payload, ['event', 'affected_muggles', 'location', 'lead_wizard']);

        $payload['event'] = $this->generateEventCode($payload);
        $payload['affected_muggles'] = (int) $payload['affected_muggles'];

        return $payload;
    }

    public function addMetadata(array $payload): array
    {
        $payload['muggle_wipe_id'] = 'MW-' . now()->format('Ymd-His');
        $payload['processed_at'] = now()->toIso8601String();
        $payload['department'] = 'Magical Accidents and Catastrophes';
        $payload['tags'] = ['muggle-wipe', strtolower(str_replace(' ', '-', $payload['event']))];

        return $payload;
    }

    protected function generateEventCode(array $payload): string
    {
        return ucwords(strtolower($payload['event']));
    }
}
