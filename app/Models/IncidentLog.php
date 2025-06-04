<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;

class IncidentLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'incident_logs';

    protected $fillable = [
        'department_id',
        'incident_id',
        'action',
        'details',
        'timestamp',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', '_id');
    }

    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class, 'incident_id', '_id');
    }
}
