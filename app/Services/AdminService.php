<?php

namespace App\Services;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\TeacherService;
use App\Services\StudentService;
class AdminService
{
    protected $teacherService;
    protected $studentService;

    public function __construct(TeacherService $teacherService, StudentService $studentService)
    {
        $this->teacherService = $teacherService;
        $this->studentService = $studentService;
    }

    public function getDashboardData()
    {
        $classes = ClassModel::with(['course', 'teacher', 'students'])->get();
        return ['classes'=>$classes];
    }

    public function updateProfile(User $user, array $data)
    {
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if (!empty($data['profile_picture'])) {
            $path = $data['profile_picture']->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->bio = $data['bio'];
        $user->save();
    }

    public function createUser(array $data)
    {
        // Validate user type
        $this->validateUserType($data['user_type']);

        // Create the user based on the user type
        switch ($data['user_type']) {
            case 'admin':
                return $this->create($data);
            case 'teacher':
                return $this->teacherService->create($data);
            case 'student':
                return $this->studentService->create($data);
            default:
                throw new InvalidArgumentException('Invalid user type');
        }
    }

    private function validateUserType($userType)
    {
        if (!in_array($userType, ['admin', 'teacher', 'student'])) {
            throw new InvalidArgumentException('Invalid user type');
        }
    }

    private function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'bio' => $data['bio'],
            'profile_picture'=>array_key_exists("profile_picture",$data)?$data['profile_picture']:null
        ]);
    }

    public function check(array $data){
        $name=$data['name'];
        $email=$data['email'];
        $id=array_key_exists('id',$data)?$data['id']:null;
        $type=array_key_exists('type',$data)?$data['type']:null;
        if ($id !== null && $type !== null) {
            switch ($type) {
                case 'admin':
                    $nameExists = User::where('name', $name)->where('id', '!=', $id)->exists()||
                                    Teacher::where('name', $name)->exists() ||
                                    Student::where('name', $name)->exists();
                    $emailExists = User::where('email', $email)->where('id', '!=', $id)->exists()||
                                    Teacher::where('email', $email)->exists() ||
                                    Student::where('email', $email)->exists();
                    break;
                case 'teacher':
                    $nameExists = Teacher::where('name', $name)->where('id', '!=', $id)->exists() ||
                                    User::where('name', $name)->exists() ||
                                    Student::where('name', $name)->exists();
                    $emailExists = Teacher::where('email', $email)->where('id', '!=', $id)->exists() ||
                                    User::where('email', $email)->exists() ||                    
                                    Student::where('email', $email)->exists();
                    break;
                case 'student':
                    $nameExists = Student::where('name', $name)->where('id', '!=', $id)->exists() || 
                                    User::where('name', $name)->exists() ||
                                    Teacher::where('name', $name)->exists();
                    $emailExists = Student::where('email', $email)->where('id', '!=', $id)->exists() ||
                                    User::where('email', $email)->exists() ||
                                    Teacher::where('email', $email)->exists();
                    break;
                default:
                    $nameExists = User::where('name', $name)->exists() ||
                        Teacher::where('name', $name)->exists() ||
                        Student::where('name', $name)->exists();
                    $emailExists = User::where('email', $email)->exists() ||
                        Teacher::where('email', $email)->exists() ||
                        Student::where('email', $email)->exists();
                    break;
            }
        } else {
            $nameExists = User::where('name', $name)->exists() ||
                Teacher::where('name', $name)->exists() ||
                Student::where('name', $name)->exists();
    
            $emailExists = User::where('email', $email)->exists() ||
                Teacher::where('email', $email)->exists() ||
                Student::where('email', $email)->exists();
        }

        return ['name_exists' => $nameExists, 'email_exists' => $emailExists];
    }

    public function GetUser($type, $id){
        switch ($type) {
            case 'admin':
                $user = User::findOrFail($id);
                break;
            case 'teacher':
                $user = Teacher::findOrFail($id);
                break;
            case 'student':
                $user = Student::findOrFail($id);
                break;
            default:
                abort(404);
        }
        return $user;
    }

    public function UpdateUser($data,$id){
        switch ($data['user_type']) {
            case 'admin':
                $user = User::findOrFail($id);
                break;
            case 'teacher':
                $user = Teacher::findOrFail($id);
                break;
            case 'student':
                $user = Student::findOrFail($id);
                break;
            default:
                abort(404);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function enableTwoFactorAuthentication(User $user, $secret)
    {
        $user->google2fa_secret = $secret;
        $user->google2fa_enabled = true;
        $user->save();
    }

    public function disableTwoFactorAuthentication(User $user)
    {
        $user->google2fa_secret = null;
        $user->google2fa_enabled = false;
        $user->save();
    }

}
