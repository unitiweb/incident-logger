<?php

namespace App\Gateways\Support;

interface IncidentGatewayInterface
{
    public function cleanPayload(array $payload): array;
    public function addMetadata(array $payload): array;
}
