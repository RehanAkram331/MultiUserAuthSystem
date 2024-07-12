<?php

namespace App\Policies;

use App\Models\Student;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    public function view(Student $student)
    {
        return true;
    }

    public function update(Student $student)
    {
        return true;
    }
}
