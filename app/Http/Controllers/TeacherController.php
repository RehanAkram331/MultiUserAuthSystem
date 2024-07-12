<?php

namespace App\Http\Controllers;

use App\Services\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function dashboard()
    {
        $data = $this->teacherService->getDashboardData();
        return view('teacher.dashboard', compact('data'));
    }

    public function index(){
        $Teachers = Teacher::all();
        return view('teacher.index', compact('Teachers'));
    }

    public function Profile(){
        $user = Auth::user();
        return view('teacher.profile.index', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::guard('teacher')->user();
        return view('teacher.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('teacher')->user();
        $this->teacherService->updateProfile($user, $request->all());
        return back()->with('success', 'Profile updated successfully.');
    }
    
}