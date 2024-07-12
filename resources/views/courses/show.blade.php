@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Course Details</h1>
    <div class="card">
        <div class="card-header">
            <h2>{{ $course->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Code:</strong> {{ $course->code }}</p>
            <p><strong>Description:</strong> {{ $course->description }}</p>
            <p><strong>Fee:</strong> ${{ $course->fee }}</p>
            <p><strong>Time:</strong> {{ $course->time }}</p>
        </div>
    </div>
    <a href="{{ route('courses.edit', $course->id) }}" class="mt-3 btn btn-primary">Edit Course</a>
    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Course</button>
    </form>
</div>
@endsection
