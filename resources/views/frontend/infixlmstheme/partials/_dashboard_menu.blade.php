@php
    $user = auth()->user();
    $profileUrl = route('users.settings');

    $portalTitle = 'Dashboard';
    if (routeIs('myLearning')) $portalTitle = 'My Learning';
    elseif (routeIs('learningProgress')) $portalTitle = 'Learning Progress';
    elseif (routeIs('myCourses')) $portalTitle = 'My Courses';
    elseif (routeIs('myQuizzes')) $portalTitle = 'Assessments / Quizzes';
    elseif (routeIs('myClasses')) $portalTitle = 'Live Classes';
    elseif (routeIs('myCertificate')) $portalTitle = 'Certificates';
    elseif (routeIs('myPurchases')) $portalTitle = 'Purchase History';
    elseif (routeIs('logged.in.devices')) $portalTitle = 'Logged-in Devices';
    elseif (routeIs('users.settings')) $portalTitle = 'Profile & Settings';
    elseif (request()->is('invoice/*')) $portalTitle = 'Invoice';
@endphp

<header class="mupo-dashboard-topbar">
    <div class="mupo-topbar-left">
        <button type="button" class="sidebar_icon d-lg-none mupo-mobile-menu" id="mupoDashboardNavOpen" aria-label="Open learner navigation" aria-controls="mupoLearnerSidebar" aria-expanded="false"><i class="fas fa-bars"></i></button>
        <button type="button" class="mupo-topbar-collapse d-none d-lg-grid" id="mupoTopbarCollapse" aria-label="Toggle learner navigation"><i class="fas fa-bars"></i></button>
        <form class="mupo-global-search" action="{{ route('courses') }}" method="GET" role="search">
            <i class="fas fa-search" aria-hidden="true"></i>
            <input type="search" name="query" value="{{ request('query') }}" placeholder="Search for courses, lessons or resources..." aria-label="Search courses, lessons or resources">
        </form>
    </div>

    <div class="mupo-topbar-actions">
        <a href="{{ route('myNotification') }}" class="mupo-notification-btn" aria-label="Notifications" title="Notifications"><i class="far fa-bell"></i>@if($user->unreadNotifications->count() > 0)<span>{{ $user->unreadNotifications->count() > 9 ? '9+' : $user->unreadNotifications->count() }}</span>@endif</a>
        <details class="mupo-profile-menu"><summary><span class="mupo-profile-avatar">@if(!empty($user->image))<img src="{{ getProfileImage($user->image, $user->name) }}" alt="{{ $user->name }}">@else{{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strrchr(' '.$user->name, ' '), 1, 1)) }}@endif</span><span class="mupo-profile-copy"><strong>{{ $user->name }}</strong><small>Learner</small></span><i class="fas fa-chevron-down"></i></summary>
            <div class="mupo-profile-dropdown"><a href="{{ $profileUrl }}"><i class="far fa-user"></i><span>My Profile</span></a><a href="{{ route('users.settings') }}"><i class="fas fa-cog"></i><span>Account Settings</span></a><a href="{{ url('/') }}"><i class="fas fa-globe-africa"></i><span>Back to MUPO Website</span></a><div class="mupo-profile-divider"></div><a class="mupo-logout-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('mupo-dashboard-logout-form').submit();"><i class="fas fa-sign-out-alt"></i><span>Log Out</span></a><form id="mupo-dashboard-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form></div>
        </details>
    </div>
</header>
