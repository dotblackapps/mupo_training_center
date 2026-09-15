@php use Illuminate\Support\Facades\Auth; @endphp
@if(auth()->user()->student_type == 'membership' && isModuleActive('Membership'))
    @includeIf('membership::membership_member_menu')
@else
<nav class="sidebar mupo-learner-sidebar">
    <div class="mupo-sidebar-brand">
        <a href="{{ url('/') }}" aria-label="Mupo Training Center Home">
            <img src="{{ asset('mupo/assets/images/mupo-logo_1.jpeg') }}" alt="MUPO Training Center">
        </a>
        <button type="button" class="sidebar_close_icon d-lg-none" aria-label="Close learner navigation"><i class="ti-close"></i></button>
    </div>

    <div class="mupo-sidebar-body">
        <nav class="mupo-sidebar-nav" aria-label="Learner navigation">
            @if(permissionCheck('studentDashboard'))
                <a href="{{ route('studentDashboard') }}" class="{{ routeIs('studentDashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i><span>Dashboard</span>
                </a>
            @endif

            <a href="{{ route('studentDashboard') }}#continue-learning">
                <i class="fas fa-book-open"></i><span>My Learning</span>
            </a>

            @if(permissionCheck('myCourses'))
                <a href="{{ route('myCourses') }}" class="{{ routeIs('myCourses') ? 'active' : '' }}">
                    <i class="far fa-play-circle"></i><span>My Courses</span>
                </a>
            @endif

            @if(permissionCheck('myQuizzes'))
                <a href="{{ route('myQuizzes') }}" class="{{ routeIs('myQuizzes') ? 'active' : '' }}">
                    <i class="far fa-file-alt"></i><span>Assessments / Quizzes</span>
                </a>
            @endif

            @if(permissionCheck('myClasses'))
                <a href="{{ route('myClasses') }}" class="{{ routeIs('myClasses') ? 'active' : '' }}">
                    <i class="fas fa-video"></i><span>Live Classes</span>
                </a>
            @endif

            @if(permissionCheck('myCertificate'))
                <a href="{{ route('myCertificate') }}" class="{{ routeIs('myCertificate') ? 'active' : '' }}">
                    <i class="fas fa-award"></i><span>Certificates</span>
                </a>
            @endif

            <a href="{{ route('studentDashboard') }}#learning-progress">
                <i class="fas fa-chart-bar"></i><span>Progress</span>
            </a>

            @if(permissionCheck('myPurchases'))
                <a href="{{ route('myPurchases') }}" class="{{ routeIs('myPurchases') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i><span>Purchase History</span>
                </a>
            @endif

            @if(permissionCheck('logged.in.devices'))
                <a href="{{ route('logged.in.devices') }}" class="{{ routeIs('logged.in.devices') ? 'active' : '' }}">
                    <i class="fas fa-desktop"></i><span>Logged-in Devices</span>
                </a>
            @endif

            <a href="{{ route('users.settings') }}" class="{{ routeIs('users.settings') ? 'active' : '' }}">
                <i class="far fa-user"></i><span>Profile & Settings</span>
            </a>

            <a href="{{ route('contact') }}">
                <i class="far fa-life-ring"></i><span>Help & Support</span>
            </a>
        </nav>

        <div class="mupo-sidebar-quote">
            <span></span>
            <p>“Education is the most powerful weapon which you can use to change the world.”</p>
            <small>— Nelson Mandela</small>
        </div>
    </div>
</nav>
@endif
