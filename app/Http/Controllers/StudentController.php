<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function dashboard()
    {
        $data = $this->studentService->getDashboardData();
        return view('student.dashboard', compact('data'));
    }

    public function index(){
        $Students = Student::all();
        return view('student.index', compact('Students'));
    }

    public function Profile(){
        $user = Auth::user();
        return view('student.profile.index', compact('user'));
    }
    public function editProfile()
    {
        $user = Auth::guard('student')->user();
        return view('student.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('student')->user();
        $this->studentService->updateProfile($user, $request->all());
        return back()->with('success', 'Profile updated successfully.');
    }
   
}