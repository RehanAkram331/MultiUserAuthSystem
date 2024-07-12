@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Course Enrollment</h1>
        <form action="{{ route('course-enrollments.update', $courseEnroll->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="class_id" class="form-label">Class:</label>
                <select class="form-control" name="class_id" id="class_id" required>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" @if ($class->id == $courseEnroll->class_id) selected @endif>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="student_id" class="form-label">Student:</label>
                <select class="form-control" name="student_id" id="student_id" required>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @if ($student->id == $courseEnroll->student_id) selected @endif>{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="fee" class="form-label">Fee:</label>
                <input type="number" class="form-control" name="fee" id="fee" value="{{ $courseEnroll->fee }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-control" name="status" id="status" required>
                    <option value="Active" @if ($courseEnroll->status == 'Active') selected @endif>Active</option>
                    <option value="Inactive" @if ($courseEnroll->status == 'Inactive') selected @endif>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Enrollment</button>
        </form>
    </div>
@endsection
