@extends('layouts.app')

@section('content')
    <div class="container">        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="text-center">Edit User</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('user.update', $user->id) }}" method="POST" id="user-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_type" value="{{ $type }}" id="type">
                    <input type="hidden" name="id" value="{{ $user->id }}" id="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
                        <span class="text-danger" id="name-alert"></span>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
                        <span class="text-danger" id="email-alert"></span>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Leave blank to keep current password" autocomplete="new-password" aria-describedby="togglePassword" required>
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
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Leave blank to keep current password">
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio:</label>
                        <textarea class="form-control" id="bio" name="bio">{{ $user->bio }}</textarea>
                        @error('bio')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture:</label>
                        <input class="form-control" type="file" name="profile_picture" id="profile_picture">
                        @if ($user->profile_picture)
                            <img src="{{ asset('storage/profile_pictures/' . $user->profile_picture) }}" alt="Profile Picture" width="150">
                        @endif
                        @error('profile_picture')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>                    
                    <div class="col-auto text-center">
                        <button type="button" class="btn btn-primary mb-3" id="create">Update User</button>
                    </div>
                </form>
            </div>
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

<script src="{{ asset('js/admin/CreateEdit.js') }}"></script>
@endpush