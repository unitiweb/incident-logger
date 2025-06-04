<?php

namespace App\Jobs;

use App\Models\Incident;
use App\Models\IncidentReport;
use App\Models\IncidentLog;
use App\Gateways\Support\IncidentGatewayFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class ProcessIncidentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $incident;

    // Maximum number of attempts to process the job
    public $tries = 3;

    // Delay in seconds before retrying the job
    public $backoff = 10;

    public function __construct(Incident $incident)
    {
        $this->incident = $incident;
    }

    public function handle()
    {
        /**
         * Simulate a random failure for testing purposes.
         */
        if (random_int(1, 5) === 1) {
            logger()->warning('Simulated failure in ProcessIncidentJob for incident: ' . $this->incident->_id);
            throw new \Exception('Simulated random failure!');
        }

        $department = $this->incident->department;
        $gateway = IncidentGatewayFactory::make($department, $this->incident->raw_input_data);

        $cleaned = $gateway->cleanPayload($this->incident->raw_input_data);
        $withMetadata = $gateway->addMetadata($cleaned);

        $report = IncidentReport::create([
            'incident_id' => $this->incident->_id,
            'department_id' => $department->_id,
            'data' => $withMetadata,
            'status' => 'processed',
            'processed_at' => now(),
        ]);

        IncidentLog::create([
            'incident_id' => $this->incident->_id,
            'action' => 'processed',
            'details' => [
                'department' => $department->name,
                'report_id' => $report->_id,
            ],
            'timestamp' => now(),
        ]);

        $this->incident->status = 'processed';
        $this->incident->save();
    }

    /**
     * Handle a job failure.
     *
     * If the job fails more than $tries times it will fail permanently
     * Lets logs the error and updates the incident status to 'failed'
     */
    public function failed(\Exception $exception)
    {
        logger()->error('ProcessIncidentJob permanently failed for incident: ' . $this->incident->_id . ' - ' . $exception->getMessage());
        $this->incident->status = 'failed';
        $this->incident->save();
    }
}
