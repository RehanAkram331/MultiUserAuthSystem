<nav class="bg-white shadow-sm navbar navbar-expand-md navbar-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            {{-- <ul class="mr-auto navbar-nav">
                <!-- Add links for all users -->
                <li class="nav-item">
                </li>
                <!-- Add more links as needed -->
            </ul> --}}

            <!-- Right Side Of Navbar -->
            <ul class="ml-auto navbar-nav">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        {{-- <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a> --}}
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a> --}}
                        </li>
                    @endif
                @else
                    @if(Auth::guard('web')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.profile') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('create') }}">Add User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher') }}">Teacher</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student') }}">Student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('courses.index') }}">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('classes.index') }}">Classes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('course-enrollments.index') }}">Enrollmented Course</a>
                        </li>
                    @elseif(Auth::guard('teacher')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('teacher.profile') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('classes.index') }}">Classes</a>
                        </li>
                    @elseif(Auth::guard('student')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.profile') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('course-enrollments.index') }}">Enrollmented Course</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('student.classes') }}">Classes</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
