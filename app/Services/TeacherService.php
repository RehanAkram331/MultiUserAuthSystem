<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TeacherService
{
    public function getDashboardData()
    {
        $classes = ClassModel::with(['course', 'students'])
                         ->where('teacher_id', Auth::user()->id)
                         ->get();
        return ['classes'=>$classes];
    }

    public function updateProfile(Teacher $teacher, array $data)
    {
        $teacher->name = $data['name'];
        $teacher->email = $data['email'];

        if (!empty($data['password'])) {
            $teacher->password = Hash::make($data['password']);
        }

        if (!empty($data['profile_picture'])) {
            $name = $this->storeProfilePicture($data['profile_picture']);;
            $teacher->profile_picture = $name;
        }

        $teacher->bio = $data['bio'];
        $teacher->save();
    }

    public function create(array $data)
    {

        return Teacher::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'bio' => $data['bio'],
            'profile_picture'=>array_key_exists("profile_picture",$data)?$data['profile_picture']:null
        ]);
    }

    public function storeProfilePicture($data){
        $file = $data;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('/storage/profile_pictures');
        $file->move($destinationPath, $filename);
        //$file->storeAs('profile_pictures', $filename, 'public');
        return $filename;
    }
}
