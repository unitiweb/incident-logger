<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'department_id',
        'name',
        'role',
        'magic_token',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', '_id');
    }
}
