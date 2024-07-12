@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $class->name }}</h1>
        <p><strong>Description:</strong> {{ $class->description }}</p>
        <p><strong>Start Time:</strong> {{ $class->StartTime }}</p>
        <p><strong>End Time:</strong> {{ $class->EndTime }}</p>
        <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('classes.destroy', $class->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
@endsection
