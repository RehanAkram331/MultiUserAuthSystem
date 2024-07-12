@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1 class="text-center">Add Course</h1>
    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="code" class="form-label">Code:</label>
                    <input type="text" class="form-control" name="code" id="code" placeholder="Code" autocomplete="off" required>
                    @error('code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Description" autocomplete="off"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="fee" class="form-label">Fee:</label>
                    <input type="number" class="form-control" name="fee" id="fee" placeholder="Fee" autocomplete="off" required>
                    @error('fee')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="hours" class="form-label">Hours:</label>
                    <input type="number" class="form-control" name="hours" id="hours" placeholder="Hours" autocomplete="off">
                    @error('hours')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror                
                </div>
                <div class="col-auto text-center">
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
