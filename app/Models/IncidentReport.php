<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;

class IncidentReport extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'incident_reports';

    protected $fillable = [
        'incident_id',
        'department_id',
        'data',
        'status',
        'processed_at',
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
