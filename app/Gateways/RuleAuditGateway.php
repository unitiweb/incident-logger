<?php

namespace App\Gateways;

use App\Gateways\Support\IncidentGatewayBase;

/**
 * Sample Payload Gateway for Rule Audits
 *  {
 *      "patrol_id": "MLEP-2025-001",
 *      "officer": "Dawlish",
 *      "rule_broken": "Statute of Secrecy",
 *      "evidence": ["photograph", "wand trace"]
 *  }
 */
class RuleAuditGateway extends IncidentGatewayBase
{
    public function cleanPayload(array $payload): array
    {
        $this->validateRequiredFields($payload, ['patrol_id', 'officer', 'rule_broken', 'evidence']);

        $payload['officer'] = ucwords(strtolower($payload['officer']));
        $payload['evidence'] = $this->generateEvidenceArray($payload);

        return $payload;
    }

    public function addMetadata(array $payload): array
    {
        $payload['rule_audit_id'] = 'RA-' . now()->format('Ymd-His');
        $payload['processed_at'] = now()->toIso8601String();
        $payload['department'] = 'Magical Law Enforcement Patrol';
        $payload['tags'] = ['rule-audit', strtolower(str_replace(' ', '-', $payload['rule_broken']))];

        return $payload;
    }

    protected function generateEvidenceArray(array $payload): array
    {
        if (!is_array($payload['evidence']) && !empty($payload['evidence'])) {
            return [$payload['evidence']];
        }

        if (empty($payload['evidence'])) {
            return [];
        }

        return $payload['evidence'];
    }
}
