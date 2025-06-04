<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Department extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $connection = 'mongodb';
    protected $collection = 'departments';

    protected $fillable = [
        'name',
        'magic_token',
        'priority_level',
        'processing_behavior',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_id', '_id');
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class, 'department_id', '_id');
    }

    public function incidentReports()
    {
        return $this->hasMany(IncidentReport::class, 'department_id', '_id');
    }

    public function incidentLogs()
    {
        return $this->hasMany(IncidentLog::class, 'department_id', '_id');
    }
}
