<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel; // Replace with your actual model name
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class ClassController extends Controller
{
    public function index()
    {
        if (Auth::guard('teacher')->check()) {
            $user=Auth::guard('teacher')->user();
            $classes = ClassModel::with('teacher', 'course')->where('teacher_id',$user->id)->get();
        }else{
            $classes = ClassModel::with('teacher', 'course')->get();
        }
        $classes = ClassModel::with('teacher', 'course')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        if (Auth::guard('teacher')->check()) {
            $user=Auth::guard('teacher')->user();
            $teachers = Teacher::where('id',$user->id)->get();
        }else{
            $teachers = Teacher::all();
        }
        
        $courses = Course::all();
        return view('classes.create', compact('teachers', 'courses'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);
        $class = ClassModel::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    public function show($id)
    {
        $class = ClassModel::findOrFail($id);
        return view('classes.show', compact('class'));
    }

    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);
        $teachers = Teacher::all();
        $courses = Course::all();
        return view('classes.edit', compact('class', 'teachers', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'start_time' => 'nullable|string',
            'end_time' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $class = ClassModel::findOrFail($id);
        $class->update([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
