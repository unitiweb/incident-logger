<?php

namespace App\Policies;

use App\Models\Department;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{
    /**
     * Allow a department to view only its own reports.
     */
    public function viewAny(Department $authDepartment, Department $routeDepartment)
    {
        return $authDepartment->getKey() === $routeDepartment->getKey()
            ? Response::allow()
            : Response::deny('You do not have permission to view reports for this department.');
    }
}