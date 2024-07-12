@extends('layouts.app')

@section('content')
    <div class="container">        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
       
        <h1 class="text-center mt-5 pt-5">Login</h1>
        <div class="row">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="col-md-6 offset-md-3">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email:</label>
                        <input class="form-control" type="email" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password:</label>
                        <div class="input-group">
                            <input class="form-control" type="password" id="password" name="password" aria-describedby="togglePassword" required>
                            <span class="input-group-text" id="togglePassword">Show</span>
                        </div>  
                    </div>
                    <div class="col-auto text-center">
                        <button type="submit"  class="btn btn-primary px-4 py-2">Login</button>
                    </div>
                    <div class="col-auto text-center">
                        @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <p class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $("#togglePassword").click(function () {
        let passwordField = $("#password");
        let passwordFieldType = passwordField.attr("type");
        if (passwordFieldType == "password") {
            passwordField.attr("type", "text");
            $(this).text("Hide");
        } else {
            passwordField.attr("type", "password");
            $(this).text("Show");
        }
    });
</script>
@endpush