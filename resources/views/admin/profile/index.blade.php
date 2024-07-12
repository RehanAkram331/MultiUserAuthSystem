@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Profile</h1>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="mb-3 text-center">
                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" width="50%">
                    @endif
                    @error('profile_picture')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>:</th>
                            <th>{{ $user->name }}</th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>:</th>
                            <th>{{ $user->email }}</th>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <th>:</th>
                            <th class="text-wrap">{{ $user->bio }}</th>
                        </tr>
                    </table>
                </div>
                <div class="col-auto text-center">
                    @csrf
                    <button value="Enable" class="btn btn-info enable {{ $user->google2fa_secret!=null?"d-none":"" }}">Enable Two Factor</button>
                    <button value="Disable" class="btn btn-success disable {{ $user->google2fa_secret==null?"d-none":"" }}">Disable Two Factor</button>
                    <a class="btn btn-primary" href="{{ route('admin.profile.edit') }}">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="{{ asset('js/admin/Profile.js') }}"></script>
@endpush