@extends('layouts.app')

@section('content')
    <div class="container">        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <h1 class="text-center">Create Profile</h1>
            <form action="{{ route('user.store') }}" id="user-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 offset-md-3">
                    <div class="mb-3">
                        <label for="user_type" class="form-label">User Type:</label>
                        <select class="form-control" name="user_type" id="user_type"  required>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                            <option value="student">Student</option>
                        </select>
                        @error('user_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off" required>
                        <span class="text-danger" id="name-alert"></span>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" autocomplete="off" required>
                        <span class="text-danger" id="email-alert"></span>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="password" autocomplete="off" aria-describedby="togglePassword" required>
                            <span class="input-group-text" id="togglePassword">Show</span>
                        </div>                        
                        <ul id="password-requirements" style="font-size:12px; ">
                            <li id="length" class="invalid">Minimum length 8 characters</li>
                            <li id="lowercase" class="invalid">One lowercase letter</li>
                            <li id="uppercase" class="invalid">One uppercase letter</li>
                            <li id="number" class="invalid">One number</li>
                            <li id="special" class="invalid">One special character (@, $, !, %, *, #, ?, &)</li>
                            <li id="confirm" class="invalid">Confirm password not match</li>
                        </ul>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" autocomplete="off" required>
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture:</label>
                        <input class="form-control" type="file" name="profile_picture" id="profile_picture">
                        @error('profile_picture')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio:</label>
                        <textarea class="form-control" id="bio" name="bio"  placeholder="Bio" autocomplete="off"></textarea>
                        @error('bio')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-auto text-center">
                        <button type="button" class="btn btn-primary mb-3" id="create">Create Admin</button>
                    </div>
                </div>
            </form>  
        </div>      
    </div>
@endsection

@push('style')
    <style>
        .invalid {
            color: red;
        }
        .valid {
            color: green;
        }
    </style>
@endpush
@push('scripts')

<script>
$(document).ready(function () {
    $("#user_type").change(function () {
        if ($(this).val() == "admin") {
            $("#create").text("Create Admin");
        } else if ($(this).val() == "teacher") {
            $("#create").text("Create Teacher");
        } else if ($(this).val() == "student") {
            $("#create").text("Create Student");
        }
    });
});
</script>

<script src="{{ asset('js/admin/CreateEdit.js') }}"></script>
@endpush