<?php

namespace App\Gateways;

use App\Gateways\Support\IncidentGatewayBase;
use Illuminate\Support\Str;

/**
 * Sample payload for the AnomalyRoutingGateway:
 *  {
 *      "phenomenon": "Time Loop",
 *      "witnesses": ["Luna Lovegood"],
 *      "anomaly_level": "high",
 *      "notes": "Temporal distortion detected in the Department of Mysteries."
 *  }
 */
class AnomalyRoutingGateway extends IncidentGatewayBase
{
    public function cleanPayload(array $payload): array
    {
        $this->validateRequiredFields($payload, ['phenomenon', 'anomaly_level']);

        $payload['anomaly_level'] = $this->generateAnomalyLevel($payload);
        $payload['anomaly_code'] = $this->generateAnomalyCode($payload);

        return $payload;
    }

    public function addMetadata(array $payload): array
    {
        $payload['routed_department'] = 'Department of Mysteries';
        $payload['processed_at'] = now()->toIso8601String();
        $payload['tags'] = ['anomaly-routing', strtolower(str_replace(' ', '-', $payload['phenomenon']))];

        return $payload;
    }

    protected function generateAnomalyLevel(array $payload): string
    {
        return strtolower($payload['anomaly_level']);
    }

    protected function generateAnomalyCode(array $payload): string
    {
        return 'ANOM-' . Str::upper(Str::random(8));
    }
}