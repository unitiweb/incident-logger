<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class Incident extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'incidents';

    protected $fillable = [
        'raw_input_data',
        'department_id',
        'status',
        'timestamp',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', '_id');
    }

    public function incidentLogs(): HasMany
    {
        return $this->hasMany(IncidentLog::class, 'incident_id', '_id');
    }

    public function incidentReports(): HasMany
    {
        return $this->hasMany(IncidentReport::class, 'incident_id', '_id');
    }
}
