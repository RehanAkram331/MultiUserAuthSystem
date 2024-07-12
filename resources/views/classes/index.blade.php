@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <h1 class="text-center mt-5">Classes</h1>
        @if(Auth::guard('web')->check() || Auth::guard('teacher')->check())
            <a href="{{ route('classes.create') }}" class="btn btn-primary mb-2">Add Class</a>
        @endif
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Teacher</th>                    
                    <th>StartTime</th>
                    <th>EndTime</th>
                    <th class="text-wrap">Class Description</th>
                    <th>Course</th>
                    <th>Code</th>
                    <th>Fee</th>
                    <th>Hours</th>
                    <th class="text-wrap">Courese Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($classes->count()>0)
                    @foreach ($classes as $class)
                    <tr>
                        <td class="text-wrap">{{ $class->name }}</td>
                        <td class="text-wrap">{{ $class->teacher->name }}</td>                        
                        <td class="text-wrap">{{ $class->start_time }}</td>
                        <td class="text-wrap">{{ $class->end_time }}</td>
                        <td class="text-wrap">{{ $class->description }}</td>
                        <td class="text-wrap">{{ $class->course->name }}</td>
                        <td class="text-wrap">{{ $class->course->code }}</td>
                        <td class="text-wrap">{{ $class->course->fee }}</td>
                        <td class="text-wrap">{{ $class->course->hours }}</td>
                        <td class="text-wrap">{{ $class->course->description }}</td>
                        <td class="text-wrap">
                            @if(Auth::guard('web')->check() || Auth::guard('teacher')->check())
                                <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm deleteButton">Delete</button>
                                </form>
                            @elseif(Auth::guard('student')->check())
                            <form action="{{ route('course-enrollments.store') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" class="classes_id" value="{{ $class->id }}">
                                <input type="hidden" class="fee" value="{{ $class->course->fee }}">
                                <button type="button" class="btn btn-primary btn-sm deleteButton">Enrole</button>
                            </form>
                            @endif
                        </td>
                    </tr>
    
                    @endforeach
                @else
                <tr>
                    <td colspan="7" class="text-wrap text-center">No Class Found!</td>
                </tr>
                @endif
            </tbody>
        </table>
        </div>
        
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('.enrole').click(function(){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Enrole it!"
            }).then((result) => {
            if (result.isConfirmed) {
                let classe_id = $(this).closest('form').find('.classes_id').val();
                let fee = $(this).closest('form').find('.fee').val();
                $.ajax({
                    url: "{{ route('course-enrollments.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        classe_id,
                        fee,
                    },
                    success: (response) => {
                        if(response.status == 201){
                            Swal.fire({
                                title: "Enroled!",
                                text: response.message,
                                icon: "success"
                            });
                        }else{
                            Swal.fire({
                                title: "error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                         
                    },
                    error: (error) => {
                        let errors = error.responseJSON.message;
                        Swal.fire({
                            title: "error!",
                            text: errors,
                            icon: "error"
                        });
                    }
                });               
                
            }
        });
    })
})
</script>    
@endpush