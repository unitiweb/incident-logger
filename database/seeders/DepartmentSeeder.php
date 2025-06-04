<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'name' => 'Auror Office',
                'description' => 'Handles dark wizard investigations and magical law enforcement.',
                'processing_behavior' => 'combat-protocol',
                'priority_level' => 'medium',
                'magic_token' => 'auror-office-token-123',
            ],
            [
                'name' => 'Department of Mysteries',
                'description' => 'Conducts research on the mysteries of magic, including time, space, and death.',
                'processing_behavior' => 'anomaly-routing',
                'priority_level' => 'high',
                'magic_token' => 'department-of-mysteries-token-123',
            ],
            [
                'name' => 'Improper Use of Magic Office',
                'description' => 'Manages magical accidents and disasters, ensuring public safety.',
                'processing_behavior' => 'compliance-check',
                'priority_level' => 'medium',
                'magic_token' => 'improper-use-of-magic-token-123',
            ],
            [
                'name' => 'Magical Law Enforcement Patrol',
                'description' => 'Manages magical accidents and disasters, ensuring public safety.',
                'processing_behavior' => 'rule-audit',
                'priority_level' => 'low',
                'magic_token' => 'magical-law-enforcement-patrol-token-123',
            ],
            [
                'name' => 'Magical Accidents and Catastrophes',
                'description' => 'Manages magical accidents and disasters, ensuring public safety.',
                'processing_behavior' => 'muggle-wipe',
                'priority_level' => 'low',
                'magic_token' => 'magical-accidents-and-catastrophes-token-123',
            ],
        ];

        foreach ($departments as $data) {
            Department::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'priority_level' => $data['priority_level'],
                'processing_behavior' => $data['processing_behavior'],
                'magic_token' => $data['magic_token'],
                // For mor secure token generation
                // 'magic_token' => Str::random(32),
            ]);
        }
    }
}
