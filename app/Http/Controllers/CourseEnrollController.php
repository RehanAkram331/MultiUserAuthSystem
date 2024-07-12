<?php

namespace App\Http\Controllers;

use App\Models\CourseEnroll;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;

class CourseEnrollController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('student')->check()){
            $user=Auth::guard('student')->user();
            $courseEnrollments = CourseEnroll::with(['class', 'student'])
                                ->where('student_id', $user->id)
                                ->get();
        }else{
            $courseEnrollments = CourseEnroll::with(['class', 'student'])->get();
        }
        
        return view('course-enrollments.index', compact('courseEnrollments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = ClassModel::all();
        $students = Student::all();
        return view('course-enrollments.create', compact('classes', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'classe_id' => 'required|exists:classes,id',
           // 'student_id' => 'required|exists:students,id',
            'fee' => 'required|numeric',
            //'status' => 'required|in:Active,Inactive',
        ]);

        $data['student_id']= $this->authService->getAuthenticatedUser()->id;


        // Check if the enrollment already exists
        $exists = CourseEnroll::where('student_id', $data['student_id'])
                            ->where('classe_id', $data['classe_id'])
                            ->exists();

        if ($exists) {
            return response()->json(['message' => 'This enrollment already exists.'], 400);
        }

        CourseEnroll::create($data);

        return response()->json([
            'message' => 'Course enrollment created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseEnroll  $courseEnroll
     * @return \Illuminate\Http\Response
     */
    public function show(CourseEnroll $courseEnroll)
    {
        return view('course-enrollments.show', compact('courseEnroll'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseEnroll  $courseEnroll
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseEnroll $courseEnroll)
    {
        $classes = ClassModel::all();
        $students = Student::all();
        return view('course-enrollments.edit', compact('courseEnroll', 'classes', 'students'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseEnroll  $courseEnroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseEnroll $courseEnroll)
    {
        $data = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
            'fee' => 'required|numeric',
            'status' => 'required|in:Active,Inactive',
        ]);

        $courseEnroll->update($data);

        return redirect()->route('course-enrollments.index')
                         ->with('success', 'Course enrollment updated successfully.');
    }


    public function active($id){
        $courseEnroll = CourseEnroll::findOrFail($id);   
        $courseEnroll->status="Active";
        //dd($courseEnroll->status);
        $courseEnroll->save();
        return response()->json([
            'message' => 'Status Updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseEnroll  $courseEnroll
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courseEnroll = CourseEnroll::findOrFail($id);
        if($courseEnroll!=null){
            $courseEnroll->delete();
        }        

        return redirect()->route('course-enrollments.index')
                         ->with('success', 'Course enrollment deleted successfully.');
    }
}
