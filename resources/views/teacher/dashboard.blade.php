@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-center mt-5 mb-2">Your Classes</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class</th>
                        <th>Course</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Description</th>
                        <th>Number of Students</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['classes'] as $class)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->course->name }}</td>
                            <td>{{ $class->start_time }}</td>
                            <td>{{ $class->end_time }}</td>
                            <td>{{ $class->description }}</td>
                            <td>{{ $class->students->count() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">You are not teaching any classes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table> 
        </div>
        
    </div>
@endsection
