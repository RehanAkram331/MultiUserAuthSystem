<?php

namespace App\Policies;

use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    public function view(Teacher $teacher)
    {

        return true;
    }

    public function update(Teacher $teacher)
    {
        return true;
    }
}