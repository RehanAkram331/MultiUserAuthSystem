<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Display a listing of the courses.
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    // Show the form for creating a new course.
    public function create()
    {
        return view('courses.create');
    }

    // Store a newly created course in storage.
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses',
            'description' => 'nullable|string',
            'fee' => 'required|numeric',
            'hours' => 'nullable|string',
        ]);

        Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    // Display the specified course.
    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    // Show the form for editing the specified course.
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Update the specified course in storage.
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses,code,' . $course->id,
            'description' => 'nullable|string',
            'fee' => 'required|numeric',
            'hours' => 'nullable|string',
        ]);

        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    // Remove the specified course from storage.
    public function destroy($id)
    {
        $course=Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
