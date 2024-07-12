@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Users List</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Bio</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Teachers as $Teacher)
                                <tr>
                                    <td>{{ $Teacher->id }}</td>
                                    <td>{{ $Teacher->name }}</td>
                                    <td>{{ $Teacher->email }}</td>
                                    <td>{{ $Teacher->bio }}</td>
                                    <td>
                                        <a href="{{ route('user.edit', ['type' => 'teacher', 'id' => $Teacher->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('user.destroy', ['type' => 'teacher', 'id' => $Teacher->id]) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm deleteButton">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>
@endsection
