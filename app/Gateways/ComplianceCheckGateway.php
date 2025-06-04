<?php

namespace App\Gateways;

use App\Gateways\Support\IncidentGatewayBase;

/**
 * Sample Payload Gateway for Compliance Checks
 *  {
 *      "wizard_name": "Harry Potter",
 *      "incident_type": "Underage Magic",
 *      "location": "Privet Drive",
 *      "reported_by": "Muggle"
 *  }
 */
class ComplianceCheckGateway extends IncidentGatewayBase
{
    public function cleanPayload(array $payload): array
    {
        $this->validateRequiredFields($payload, ['wizard_name', 'incident_type', 'location', 'reported_by']);

        $payload['muggle_involved'] =  $this->isMuggleInvolved($payload);
        $payload['incident_type'] = $this->generateIncidentType($payload);

        return $payload;
    }

    public function addMetadata(array $payload): array
    {
        $payload['compliance_check_id'] = 'CC-' . now()->format('Ymd-His');
        $payload['processed_at'] = now()->toIso8601String();
        $payload['department'] = 'Improper Use of Magic Office';
        $payload['tags'] = ['compliance-check', strtolower(str_replace(' ', '-', $payload['incident_type']))];

        return $payload;
    }

    protected function generateIncidentType(array $payload): string
    {
        return ucwords(strtolower($payload['incident_type']));
    }

    protected function isMuggleInvolved(array $payload): bool
    {
        return strtolower($payload['reported_by']) === 'muggle';
    }
}
