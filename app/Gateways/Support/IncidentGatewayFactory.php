<?php

namespace App\Gateways\Support;

use App\Gateways\AnomalyRoutingGateway;
use App\Gateways\CombatProtocolGateway;
use App\Gateways\ComplianceCheckGateway;
use App\Gateways\DefaultIncidentGateway;
use App\Gateways\MuggleWipeGateway;
use App\Gateways\RuleAuditGateway;
use App\Models\Department;

class IncidentGatewayFactory
{
    /**
     * Resolve the correct gateway for the processing behavior.
     */
    public static function make(Department $department): IncidentGatewayInterface
    {
        return match ($department->processing_behavior) {
            'combat-protocol' => new CombatProtocolGateway($department),
            'anomaly-routing' => new AnomalyRoutingGateway($department),
            'compliance-check' => new ComplianceCheckGateway($department),
            'rule-audit' => new RuleAuditGateway($department),
            'muggle-wipe' => new MuggleWipeGateway($department),
            default => new DefaultIncidentGateway($department),
        };
    }
}
