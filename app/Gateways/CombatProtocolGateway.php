<?php

namespace App\Gateways;

use App\Gateways\Support\IncidentGatewayBase;

/**
 * Sample Payload Gateway for Combat Protocols
 *  {
 *      "suspect_name": "Bellatrix Lestrange",
 *      "crime_type": "Dark Magic" | "Unauthorized Duel" | "Minor Offense",
 *      "location": "Hogsmeade",
 *      "auror_on_scene": "Kingsley Shacklebolt",
 *      "witnesses": ["Minerva McGonagall", "Seamus Finnigan"]
 *  }
 */
class CombatProtocolGateway extends IncidentGatewayBase
{
    protected array $combatLevels = [
        'Dark Magic',
        'Unauthorized Duel',
        'Minor Offense',
    ];

    public function cleanPayload(array $payload): array
    {
        $this->validateRequiredFields($payload, ['suspect_name', 'crime_type', 'location']);

        $payload['combat_level'] = $combatLevels[$payload['crime_type']] ?? 'unknown';

        return $payload;
    }

    public function addMetadata(array $payload): array
    {
        $payload['combat_report_id'] = 'CP-' . now()->format('Ymd-His');
        $payload['processed_at'] = now()->toIso8601String();
        $payload['department'] = $this->department;
        $payload['tags'] = ['combat-protocol', strtolower(str_replace(' ', '-', $payload['crime_type'] ?? 'unknown'))];

        return $payload;
    }
}
