@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Course Enrollment Details</h1>
        <div>
            <strong>Class:</strong> {{ $courseEnroll->class->name }} <br>
            <strong>Student:</strong> {{ $courseEnroll->student->name }} <br>
            <strong>Fee:</strong> {{ $courseEnroll->fee }} <br>
            <strong>Status:</strong> {{ $courseEnroll->status }} <br>
            <strong>Created At:</strong> {{ $courseEnroll->created_at }} <br>
            <strong>Updated At:</strong> {{ $courseEnroll->updated_at }} <br>
        </div>
        <br>
        <a href="{{ route('course-enrollments.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
