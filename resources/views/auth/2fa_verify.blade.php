@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center text-wrap">Two-Factor Authentication</h2>
    <div  class="text-center text-wrap">
        {!! $QR_Image !!}
    </div>
    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-group mb-3">
                    <label for="verify-code">Verification Code</label>
                    <input type="text" name="verify-code" id="verify-code" class="form-control" required>
                    @error('verify-code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-auto text-center">
            <button type="submit" class="btn btn-primary">Verify</button>
        </div>
    </form>
</div>
@endsection
