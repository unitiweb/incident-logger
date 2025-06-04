<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Incident;
use App\Jobs\ProcessIncidentJob;

class SpellResidueAnalyzer extends Command
{
    protected $signature = 'spell:residue-analyze';
    protected $description = 'Reprocess all incomplete incidents';

    public function handle()
    {
        $incomplete = Incident::whereIn('status', ['pending', 'failed'])->get();

        $this->line('');
        $this->info('|-----------------------------------------------------------');
        $this->comment("| Found {$incomplete->count()} incomplete incidents.");

        foreach ($incomplete as $incident) {
            ProcessIncidentJob::dispatch($incident);
            $this->line("| Re-dispatched incident: {$incident->_id}");
        }

        $this->comment('| Reprocessing complete!');
        $this->info('|-----------------------------------------------------------');
        $this->line('');
    }
}