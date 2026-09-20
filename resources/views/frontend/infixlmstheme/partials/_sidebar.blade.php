@php use Illuminate\Support\Facades\Auth; @endphp
@if(auth()->user()->student_type == 'membership' && isModuleActive('Membership'))
    @includeIf('membership::membership_member_menu')
@else
<nav class="sidebar mupo-learner-sidebar" id="mupoLearnerSidebar">
    <div class="mupo-sidebar-brand">
        <a href="{{ url('/') }}" class="mupo-sidebar-logo" aria-label="Mupo Training Center Home">
            <img src="{{ asset('mupo/assets/images/mupo-logo_1.jpeg') }}" alt="MUPO Training Center">
        </a>
        <button type="button" class="mupo-sidebar-collapse d-none d-lg-grid" id="mupoSidebarCollapse" aria-label="Collapse learner navigation" title="Collapse sidebar">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <button type="button" class="sidebar_close_icon d-lg-none" aria-label="Close learner navigation">
            <i class="ti-close"></i>
        </button>
    </div>

    <div class="mupo-sidebar-body">
        <div class="mupo-sidebar-identity">
            <strong>LEARNER PORTAL</strong>
            <span>Learn <b>•</b> Grow <b>•</b> Succeed</span>
        </div>

        <nav class="mupo-sidebar-nav" aria-label="Learner navigation">
            <div class="mupo-nav-group">
                <div class="mupo-nav-label">LEARNING</div>

                @if(permissionCheck('studentDashboard'))
                    <a href="{{ route('studentDashboard') }}" class="{{ routeIs('studentDashboard') ? 'active' : '' }}" title="Dashboard">
                        <i class="fas fa-home"></i><span>Dashboard</span>
                    </a>
                @endif

                <a href="{{ route('myLearning') }}" class="{{ routeIs('myLearning') ? 'active' : '' }}" title="My Learning">
                    <i class="fas fa-book-open" aria-hidden="true"></i><span>My Learning</span>
                </a>

                @if(permissionCheck('myCourses'))
                    <a href="{{ route('myCourses') }}" class="{{ (routeIs('myCourses') || request()->is('fullscreen-view/*')) ? 'active' : '' }}" title="My Courses">
                        <i class="fas fa-book-open"></i><span>My Courses</span>
                    </a>
                @endif

                @if(permissionCheck('myQuizzes'))
                    <a href="{{ route('myQuizzes') }}" class="{{ routeIs('myQuizzes') ? 'active' : '' }}" title="Assessments / Quizzes">
                        <i class="far fa-file-alt"></i><span>Assessments / Quizzes</span>
                    </a>
                @endif

                @if(permissionCheck('myClasses'))
                    <a href="{{ route('myClasses') }}" class="{{ routeIs('myClasses') ? 'active' : '' }}" title="Live Classes">
                        <i class="fas fa-video"></i><span>Live Classes</span>
                    </a>
                @endif

                <a href="{{ route('myHomework') }}" class="{{ routeIs('myHomework') ? 'active' : '' }}" title="Learning Material">
                    <i class="far fa-file-alt"></i><span>Learning Material</span>
                </a>
            </div>

            <div class="mupo-nav-group">
                <div class="mupo-nav-label">ACHIEVEMENT</div>

                <a href="{{ route('learningProgress') }}" class="{{ routeIs('learningProgress') ? 'active' : '' }}" title="Progress">
                    <i class="fas fa-chart-bar"></i><span>Progress</span>
                </a>

                @if(permissionCheck('myCertificate'))
                    <a href="{{ route('myCertificate') }}" class="{{ routeIs('myCertificate') ? 'active' : '' }}" title="Certificates">
                        <i class="fas fa-award"></i><span>Certificates</span>
                    </a>
                @endif
            </div>

            <div class="mupo-nav-group">
                <div class="mupo-nav-label">ACCOUNT</div>

                @if(permissionCheck('myPurchases'))
                    <a href="{{ route('myPurchases') }}" class="{{ routeIs('myPurchases') ? 'active' : '' }}" title="Purchase History">
                        <i class="fas fa-receipt"></i><span>Purchase History</span>
                    </a>
                @endif

                @if(permissionCheck('logged.in.devices'))
                    <a href="{{ route('logged.in.devices') }}" class="{{ routeIs('logged.in.devices') ? 'active' : '' }}" title="Logged-in Devices">
                        <i class="fas fa-desktop"></i><span>Logged-in Devices</span>
                    </a>
                @endif

                <a href="{{ route('users.settings') }}" class="{{ routeIs('users.settings') ? 'active' : '' }}" title="Profile & Settings">
                    <i class="far fa-user"></i><span>Profile & Settings</span>
                </a>
            </div>

            <div class="mupo-nav-group mupo-support-group">
                <div class="mupo-nav-label">SUPPORT</div>
                <a href="{{ route('contact') }}" title="Help & Support">
                    <i class="far fa-life-ring"></i><span>Help & Support</span>
                </a>
            </div>
        </nav>
        <div class="mupo-sidebar-bottom">
            <a class="mupo-back-site" href="{{ url('/') }}">
                <i class="far fa-compass" aria-hidden="true"></i><span>Back to MUPO Website</span>
            </a>
            <div class="mupo-sidebar-motto" aria-label="MUPO learner portal motto">
                <span aria-hidden="true"></span><strong>EMPOWERING MINDS.<br>BUILDING FUTURES.</strong>
            </div>
        </div>
    </div>
</nav>
@endif
