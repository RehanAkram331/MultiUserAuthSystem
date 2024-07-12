<?php

namespace App\Services;

use App\Models\Student;
use App\Models\CourseEnroll;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudentService
{
    public function getDashboardData()
    {
        $courseEnrollments = CourseEnroll::with(['class', 'student'])
        ->where('student_id', Auth::user()->id)
        ->where('status',1)
        ->get();
        // Fetch and return student-specific data
        return ['courseEnrollments'=>$courseEnrollments];
    }

    public function updateProfile(Student $student, array $data)
    {
        $student->name = $data['name'];
        $student->email = $data['email'];

        if (!empty($data['password'])) {
            $student->password = Hash::make($data['password']);
        }

        if (!empty($data['profile_picture'])) {
            $path = $data['profile_picture']->store('profile_pictures', 'public');
            $student->profile_picture = $path;
        }

        $student->bio = $data['bio'];
        $student->save();
    }

    Public function create(array $data)
    {
        return Student::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'bio' => $data['bio'],
            'profile_picture'=>array_key_exists("profile_picture",$data)?$data['profile_picture']:null
        ]);
    }

}
