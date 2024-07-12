<?php
namespace App\Providers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Policies\AdminPolicy;
use App\Policies\StudentPolicy;
use App\Policies\TeacherPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    // protected $policies = [
    //     User::class => AdminPolicy::class,
    //     Student::class => StudentPolicy::class,
    //     Teacher::class => TeacherPolicy::class,
    // ];
    protected $policies = [
        User::class => AdminPolicy::class,
    ];
    public function boot()
    {
        $this->registerPolicies();
    }
}