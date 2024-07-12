@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- <h1>Student Dashboard</h1> --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-center mt-5 mb-2">Your Enrolled Classes</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Class</th>
                    <th>Course</th>
                    <th>Teacher</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['courseEnrollments'] as $enrollment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $enrollment->class->name }}</td>
                        <td>{{ $enrollment->class->course->name }}</td>
                        <td>{{ $enrollment->class->teacher->name }}</td>
                        <td>{{ $enrollment->class->start_time }}</td>
                        <td>{{ $enrollment->class->end_time }}</td>
                        <td>{{ $enrollment->class->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">You are not enrolled in any classes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection