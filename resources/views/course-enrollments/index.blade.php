@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Course Enrollments</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Class</th>
                    <th>Student</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courseEnrollments as $enrollment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $enrollment->class->name }}</td>
                        <td>{{ $enrollment->student->name }}</td>
                        <td>{{ $enrollment->fee }}</td>
                        <td class="status">
                            {{ $enrollment->status }}
                        </td>
                           
                            
                        <td>
                            <form action="{{ route('course-enrollments.destroy', $enrollment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                @if(Auth::guard('web')->check() && $enrollment->status == "Inactive")
                                    <button type="button" class="btn btn-info btn-sm activeButton" data-id="{{ $enrollment->id }}" >Active</button>
                                @endif
                                <button type="button" class="btn btn-danger btn-sm deleteButton" >Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".activeButton").click(function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want  to active this enrollment",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Activate it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let id = $(this).attr('data-id');
                        $.ajax({
                            url: `/admin/course-enrollments/active/${id}`,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: (response) => {
                                $(this).hide();
                                $(this).closest('tr').find('.status').text('Active');
                                Swal.fire({
                                    title: "Status!",
                                    text: response.message,
                                    icon: "success"
                                });                                
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
            });
        });
    </script>
@endpush