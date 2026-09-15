@php
    $total = Auth::user()->totalStudentCourses();
    $enrolledCourses = Auth::user()->studentCourses()->with(['course.courseLevel'])->latest('last_view_at')->get();
    $activeEnrollment = $enrolledCourses->first(function ($enrollment) {
        return $enrollment->course && round($enrollment->course->loginUserTotalPercentage) < 100;
    });
    $activeCourse = $activeEnrollment ? $activeEnrollment->course : null;
    $activeProgress = $activeCourse ? max(0, min(100, round($activeCourse->loginUserTotalPercentage))) : 0;
    $progressValues = $enrolledCourses->filter(fn($e) => $e->course)->map(fn($e) => max(0, min(100, round($e->course->loginUserTotalPercentage))));
    $overallProgress = $progressValues->count() ? (int) round($progressValues->avg()) : 0;
    $learnerId = 'MTC-' . str_pad((string) Auth::id(), 6, '0', STR_PAD_LEFT);
    $firstName = trim(explode(' ', Auth::user()->name)[0] ?? Auth::user()->name);
    $currentLessonLabel = $activeCourse ? 'Continue where you left off' : 'No active lesson yet';
@endphp

<style>
:root{--mupo-navy:#061b3a;--mupo-navy-2:#0a2a52;--mupo-red:#ed1c24;--mupo-bg:#f5f7fa;--mupo-text:#0a1f44;--mupo-muted:#667085;--mupo-line:#e3e8ef;--mupo-white:#fff}
.dashboard_main_wrapper{background:var(--mupo-bg)!important;min-height:100vh}.main_content.dashboard_part{background:var(--mupo-bg)!important}.main_content_iner{padding:18px 22px 34px!important;background:var(--mupo-bg)!important}
.mupo-learner-sidebar{background:linear-gradient(180deg,#061b3a 0%,#08294e 100%)!important;border:0!important;box-shadow:none!important}.mupo-sidebar-brand{height:74px;background:#fff;display:flex;align-items:center;justify-content:center;position:relative;border-right:1px solid var(--mupo-line)}.mupo-sidebar-brand img{height:54px;width:auto;object-fit:contain}.mupo-sidebar-brand .sidebar_close_icon{position:absolute;right:15px;color:var(--mupo-navy)}.mupo-sidebar-body{height:calc(100vh - 74px);overflow:hidden;display:flex;flex-direction:column;padding:16px 14px 14px}.mupo-sidebar-nav{display:flex;flex-direction:column;gap:5px}.mupo-sidebar-nav a{position:relative;color:#fff!important;display:flex!important;align-items:center;gap:13px;padding:13px 15px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;transition:.2s ease}.mupo-sidebar-nav a i{width:20px;text-align:center;font-size:17px}.mupo-sidebar-nav a:hover{background:rgba(255,255,255,.09)}.mupo-sidebar-nav a.active{background:var(--mupo-red)!important;color:#fff!important}.mupo-sidebar-nav a.active:before{content:"";position:absolute;left:-14px;top:8px;bottom:8px;width:3px;background:#fff;border-radius:0 3px 3px 0}.mupo-sidebar-quote{margin-top:auto;padding:22px 10px 4px;color:#fff;border-top:1px solid rgba(255,255,255,.18)}.mupo-sidebar-quote>span{display:block;width:34px;height:3px;background:var(--mupo-red);margin-bottom:13px}.mupo-sidebar-quote p{font-size:12px;line-height:1.55;margin:0 0 7px;color:#fff}.mupo-sidebar-quote small{color:rgba(255,255,255,.6)}
.mupo-dashboard-topbar{height:74px;background:#fff;border-bottom:1px solid var(--mupo-line);display:flex;align-items:center;justify-content:space-between;padding:0 28px;position:relative;z-index:30}.mupo-topbar-left,.mupo-topbar-actions{display:flex;align-items:center}.mupo-topbar-left{gap:15px}.mupo-portal-title strong{display:block;color:var(--mupo-text);font-size:17px;line-height:1.2}.mupo-portal-title span{display:block;font-size:12px;color:#7b8798;margin-top:3px}.mupo-portal-title b{font-weight:400;color:#c5cbd4;margin:0 6px}.mupo-mobile-menu{border:0;background:none;color:var(--mupo-navy);font-size:20px}.mupo-topbar-actions{gap:16px}.mupo-notification-btn{width:40px;height:40px;display:grid;place-items:center;color:var(--mupo-navy)!important;position:relative;border-radius:8px}.mupo-notification-btn:hover{background:#f3f6fa}.mupo-notification-btn span{position:absolute;top:2px;right:1px;background:var(--mupo-red);color:#fff;font-size:9px;min-width:17px;height:17px;border-radius:50%;display:grid;place-items:center;font-weight:700;border:2px solid #fff}.mupo-profile-menu{position:relative}.mupo-profile-menu summary{list-style:none;cursor:pointer;display:flex;align-items:center;gap:10px}.mupo-profile-menu summary::-webkit-details-marker{display:none}.mupo-profile-avatar{width:40px;height:40px;border-radius:50%;background:var(--mupo-navy);color:#fff;display:grid;place-items:center;font-weight:700;overflow:hidden}.mupo-profile-avatar img{width:100%;height:100%;object-fit:cover}.mupo-profile-copy strong{display:block;color:var(--mupo-text);font-size:13px;line-height:1.2}.mupo-profile-copy small{display:block;color:#7b8798;font-size:10px;margin-top:3px}.mupo-profile-menu summary>i{font-size:11px;color:var(--mupo-navy);margin-left:2px}.mupo-profile-dropdown{position:absolute;top:52px;right:0;width:210px;background:#fff;border:1px solid var(--mupo-line);border-radius:10px;box-shadow:0 14px 35px rgba(6,27,58,.12);padding:8px;z-index:100}.mupo-profile-dropdown a{display:flex;align-items:center;gap:11px;padding:11px 12px;border-radius:7px;color:var(--mupo-text)!important;text-decoration:none;font-size:13px;font-weight:600}.mupo-profile-dropdown a:hover{background:#f5f7fa;color:var(--mupo-red)!important}.mupo-profile-dropdown i{width:17px;text-align:center}
.mupo-dashboard{max-width:1500px;margin:0 auto;color:var(--mupo-text)}.mupo-hero{min-height:245px;border-radius:12px;overflow:hidden;position:relative;padding:28px;background:linear-gradient(90deg,rgba(6,27,58,.98) 0%,rgba(6,27,58,.92) 42%,rgba(6,27,58,.30) 72%,rgba(6,27,58,.05) 100%),url('{{ asset('mupo/assets/images/bulb.jpg') }}') center/cover no-repeat;color:#fff;display:flex;flex-direction:column;justify-content:center}.mupo-hero:after{content:"EMPOWERING\A MINDS.\A BUILDING\A FUTURES.";white-space:pre;position:absolute;right:28px;bottom:28px;border-left:3px solid var(--mupo-red);padding-left:16px;font-size:14px;line-height:1.35;letter-spacing:2px;font-weight:800}.mupo-hero-kicker{color:#ff323a;font-size:12px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:7px}.mupo-hero h1{font-size:35px;line-height:1.1;color:#fff!important;margin:0 0 10px;font-weight:800}.mupo-hero>p{font-size:15px;max-width:560px;margin:0 0 22px;color:rgba(255,255,255,.9)}.mupo-learner-meta{display:flex;gap:0;flex-wrap:wrap}.mupo-meta-item{display:flex;align-items:center;gap:10px;min-width:180px;padding-right:24px;margin-right:24px;border-right:1px solid rgba(255,255,255,.24)}.mupo-meta-item:last-child{border-right:0}.mupo-meta-icon{width:38px;height:38px;border:1px solid rgba(255,255,255,.3);border-radius:50%;display:grid;place-items:center}.mupo-meta-copy small{display:block;color:rgba(255,255,255,.7);font-size:10px}.mupo-meta-copy strong{display:block;color:#fff;font-size:13px;margin-top:2px}.mupo-status-dot{width:10px;height:10px;border-radius:50%;background:#20c96b;box-shadow:0 0 0 4px rgba(32,201,107,.13)}
.mupo-kpi-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:12px;margin-top:14px}.mupo-kpi{background:#fff;border:1px solid var(--mupo-line);border-radius:10px;padding:16px;min-height:125px;position:relative;box-shadow:0 5px 16px rgba(6,27,58,.035)}.mupo-kpi-icon{width:36px;height:36px;border-radius:8px;background:#fff1f2;color:var(--mupo-red);display:grid;place-items:center;font-size:17px;margin-bottom:11px}.mupo-kpi label{display:block;font-size:11px;font-weight:700;color:var(--mupo-text);margin-bottom:5px}.mupo-kpi strong{font-size:28px;line-height:1;color:var(--mupo-text)}.mupo-kpi p{font-size:10px;color:#8a94a3;margin:7px 0 0}.mupo-progress-ring{position:absolute;right:14px;bottom:16px;width:45px;height:45px;border-radius:50%;background:conic-gradient(var(--mupo-red) calc(var(--progress)*1%),#e9edf2 0);display:grid;place-items:center}.mupo-progress-ring:after{content:"";width:34px;height:34px;background:#fff;border-radius:50%}
.mupo-dashboard-grid{display:grid;grid-template-columns:1.35fr .95fr .95fr;gap:12px;margin-top:12px}.mupo-panel{background:#fff;border:1px solid var(--mupo-line);border-radius:10px;box-shadow:0 5px 16px rgba(6,27,58,.035);overflow:hidden}.mupo-panel-head{height:50px;display:flex;align-items:center;justify-content:space-between;padding:0 16px;border-bottom:1px solid var(--mupo-line)}.mupo-panel-head h3{font-size:15px!important;color:var(--mupo-text)!important;margin:0;font-weight:800}.mupo-panel-head a{font-size:11px;color:var(--mupo-red)!important;font-weight:700;text-decoration:none}.mupo-continue-body{padding:14px;display:grid;grid-template-columns:150px 1fr;gap:16px}.mupo-course-thumb{min-height:235px;border-radius:8px;background:center/cover no-repeat;position:relative;overflow:hidden}.mupo-course-thumb:before{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(6,27,58,.08),rgba(6,27,58,.2))}.mupo-course-thumb span{position:absolute;top:10px;left:10px;background:var(--mupo-navy);color:#fff;padding:5px 8px;border-radius:5px;font-size:9px;font-weight:700}.mupo-course-info h2{font-size:18px!important;line-height:1.25;color:var(--mupo-text)!important;margin:3px 0 8px;font-weight:800}.mupo-level{display:inline-block;font-size:10px;background:#f1f3f6;border-radius:5px;padding:4px 7px;color:#49566a;margin-bottom:12px}.mupo-course-progress-copy{display:flex;justify-content:space-between;font-size:11px;color:var(--mupo-muted);margin-bottom:6px}.mupo-progress-track{height:8px;background:#e7ebef;border-radius:10px;overflow:hidden}.mupo-progress-track>span{display:block;height:100%;background:var(--mupo-red);border-radius:10px}.mupo-course-details{margin:13px 0;display:grid;gap:8px}.mupo-course-detail{display:flex;align-items:flex-start;gap:9px;font-size:11px;color:var(--mupo-muted)}.mupo-course-detail i{color:var(--mupo-navy);margin-top:2px}.mupo-course-detail strong{display:block;color:var(--mupo-text);font-size:11px}.mupo-primary-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--mupo-red)!important;color:#fff!important;border-radius:7px;padding:11px 17px;font-size:12px;font-weight:800;text-decoration:none;width:100%}.mupo-primary-btn:hover{background:#cc151c!important;color:#fff!important}.mupo-empty{padding:35px 20px;text-align:center;color:var(--mupo-muted);font-size:13px}.mupo-empty i{font-size:26px;color:#b6c0cc;margin-bottom:10px;display:block}
.mupo-stack{display:grid;gap:12px}.mupo-progress-body{padding:16px}.mupo-progress-title{display:flex;justify-content:space-between;gap:12px;font-size:12px;font-weight:800;color:var(--mupo-text);margin-bottom:8px}.mupo-progress-lines{margin-top:15px;border-top:1px solid var(--mupo-line)}.mupo-progress-row{display:flex;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px solid #edf0f4;font-size:11px;color:var(--mupo-muted)}.mupo-progress-row i{width:18px;color:var(--mupo-navy);margin-right:7px}.mupo-progress-row strong{color:var(--mupo-text)}.mupo-cert-body,.mupo-activity-body{padding:15px}.mupo-cert-empty{display:flex;align-items:center;gap:12px}.mupo-cert-icon{width:45px;height:45px;border-radius:50%;background:#f1f3f6;color:#b5beca;display:grid;place-items:center;font-size:20px}.mupo-cert-empty strong{display:block;font-size:11px;color:var(--mupo-text)}.mupo-cert-empty p{font-size:10px;color:var(--mupo-muted);margin:2px 0 0}.mupo-activity-item{display:flex;gap:10px;padding:10px 0;border-bottom:1px solid #edf0f4}.mupo-activity-item:last-child{border-bottom:0}.mupo-activity-icon{width:32px;height:32px;border-radius:50%;background:#f3f5f8;color:var(--mupo-navy);display:grid;place-items:center;flex:0 0 auto}.mupo-activity-item strong{display:block;color:var(--mupo-text);font-size:11px}.mupo-activity-item p{margin:2px 0 0;color:var(--mupo-muted);font-size:10px;line-height:1.4}.mupo-activity-item .red{color:var(--mupo-red)}
.mupo-dashboard-footer{margin-top:12px;background:#fff;border:1px solid var(--mupo-line);border-radius:10px;padding:14px 18px;display:flex;align-items:center;justify-content:space-between;gap:20px}.mupo-dashboard-quote{font-size:11px;color:var(--mupo-text);font-style:italic;max-width:470px}.mupo-dashboard-quote small{display:block;color:var(--mupo-muted);font-style:normal;margin-top:4px}.mupo-feature-mini{display:flex;align-items:center;gap:25px}.mupo-feature-mini span{font-size:10px;color:var(--mupo-text);font-weight:700;text-align:center}.mupo-feature-mini i{display:block;color:var(--mupo-red);font-size:18px;margin-bottom:4px}.mupo-explore-btn{background:var(--mupo-red);color:#fff!important;text-decoration:none;padding:11px 18px;border-radius:7px;font-weight:800;font-size:11px;white-space:nowrap}
@media(max-width:1199px){.mupo-kpi-grid{grid-template-columns:repeat(3,1fr)}.mupo-dashboard-grid{grid-template-columns:1fr 1fr}.mupo-dashboard-grid>.mupo-stack:last-child{grid-column:1/-1}.mupo-hero:after{display:none}.mupo-feature-mini{display:none}}
@media(max-width:991px){.mupo-dashboard-topbar{padding:0 16px}.mupo-profile-copy{display:none}.main_content_iner{padding:14px!important}.mupo-dashboard-grid{grid-template-columns:1fr}.mupo-dashboard-grid>.mupo-stack:last-child{grid-column:auto}.mupo-kpi-grid{grid-template-columns:repeat(2,1fr)}.mupo-sidebar-quote{display:none}}
@media(max-width:640px){.mupo-portal-title span{display:none}.mupo-hero{padding:22px 18px;min-height:270px;background-position:62% center}.mupo-hero h1{font-size:28px}.mupo-learner-meta{gap:12px}.mupo-meta-item{border:0;margin:0;padding:0;min-width:calc(50% - 6px)}.mupo-kpi-grid{grid-template-columns:1fr 1fr;gap:8px}.mupo-kpi{padding:13px;min-height:115px}.mupo-kpi strong{font-size:24px}.mupo-dashboard-grid{gap:8px}.mupo-continue-body{grid-template-columns:1fr}.mupo-course-thumb{min-height:190px}.mupo-dashboard-footer{display:block}.mupo-dashboard-quote{margin-bottom:12px}.mupo-explore-btn{display:inline-flex}.mupo-profile-dropdown{right:-6px}}
</style>

<div class="main_content_iner">
    <div class="mupo-dashboard">
        <section class="mupo-hero">
            <div class="mupo-hero-kicker">Welcome Back</div>
            <h1>{{ $wish_string }}, {{ ucfirst($firstName) }}.</h1>
            <p>Continue your learning journey with Mupo Training Center.</p>
            <div class="mupo-learner-meta">
                <div class="mupo-meta-item">
                    <span class="mupo-meta-icon"><i class="far fa-user"></i></span>
                    <span class="mupo-meta-copy"><small>Learner ID</small><strong>{{ $learnerId }}</strong></span>
                </div>
                <div class="mupo-meta-item">
                    <span class="mupo-meta-icon"><i class="fas fa-graduation-cap"></i></span>
                    <span class="mupo-meta-copy"><small>Programme</small><strong>{{ $activeCourse ? $activeCourse->title : 'No active programme' }}</strong></span>
                </div>
                <div class="mupo-meta-item">
                    <span class="mupo-status-dot"></span>
                    <span class="mupo-meta-copy"><small>Status</small><strong>Active</strong></span>
                </div>
            </div>
        </section>

        <section class="mupo-kpi-grid" aria-label="Learning overview">
            <article class="mupo-kpi"><span class="mupo-kpi-icon"><i class="fas fa-graduation-cap"></i></span><label>Courses Enrolled</label><strong>{{ $total['total'] }}</strong><p>Total active enrolments</p></article>
            <article class="mupo-kpi"><span class="mupo-kpi-icon"><i class="fas fa-play"></i></span><label>Courses in Progress</label><strong>{{ $total['process'] }}</strong><p>Keep learning</p></article>
            <article class="mupo-kpi"><span class="mupo-kpi-icon"><i class="fas fa-check"></i></span><label>Completed Courses</label><strong>{{ $total['complete'] }}</strong><p>Courses completed</p></article>
            <article class="mupo-kpi"><span class="mupo-kpi-icon"><i class="fas fa-award"></i></span><label>Certificates Earned</label><strong>{{ $myCertificateNumber }}</strong><p>Certificates available</p></article>
            <article class="mupo-kpi"><span class="mupo-kpi-icon"><i class="fas fa-chart-bar"></i></span><label>Overall Progress</label><strong>{{ $overallProgress }}%</strong><p>Across your courses</p><span class="mupo-progress-ring" style="--progress:{{ $overallProgress }}"></span></article>
        </section>

        <section class="mupo-dashboard-grid">
            <article class="mupo-panel" id="continue-learning">
                <div class="mupo-panel-head"><h3>Continue Learning</h3>@if(permissionCheck('myCourses'))<a href="{{ route('myCourses') }}">View My Courses &nbsp;→</a>@endif</div>
                @if($activeCourse)
                    <div class="mupo-continue-body">
                        <div class="mupo-course-thumb" style="background-image:url('{{ getCourseImage($activeCourse->image) }}')"><span>In Progress</span></div>
                        <div class="mupo-course-info">
                            <h2>{{ $activeCourse->title }}</h2>
                            @if($activeCourse->courseLevel)<span class="mupo-level">{{ $activeCourse->courseLevel->title }}</span>@endif
                            <div class="mupo-course-progress-copy"><span>{{ $activeProgress }}% Complete</span><strong>{{ $activeProgress }}%</strong></div>
                            <div class="mupo-progress-track"><span style="width:{{ $activeProgress }}%"></span></div>
                            <div class="mupo-course-details">
                                <div class="mupo-course-detail"><i class="far fa-bookmark"></i><span><strong>Current Learning</strong>{{ $currentLessonLabel }}</span></div>
                                <div class="mupo-course-detail"><i class="far fa-clock"></i><span><strong>Last activity</strong>{{ $activeEnrollment && $activeEnrollment->last_view_at ? showDate($activeEnrollment->last_view_at) : 'Ready when you are' }}</span></div>
                            </div>
                            <a class="mupo-primary-btn" href="{{ route('continueCourse', [$activeCourse->slug]) }}">Continue Learning <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                @else
                    <div class="mupo-empty"><i class="fas fa-book-open"></i><strong>No course currently in progress.</strong><br>Choose a course to begin your learning journey.</div>
                @endif
            </article>

            <div class="mupo-stack" id="learning-progress">
                <article class="mupo-panel">
                    <div class="mupo-panel-head"><h3>Your Learning Progress</h3>@if(permissionCheck('myCourses'))<a href="{{ route('myCourses') }}">View Details &nbsp;→</a>@endif</div>
                    <div class="mupo-progress-body">
                        <div class="mupo-progress-title"><span>{{ $activeCourse ? $activeCourse->title : 'Overall learning' }}</span><strong>{{ $activeCourse ? $activeProgress : $overallProgress }}%</strong></div>
                        <div class="mupo-progress-track"><span style="width:{{ $activeCourse ? $activeProgress : $overallProgress }}%"></span></div>
                        <div class="mupo-progress-lines">
                            <div class="mupo-progress-row"><span><i class="fas fa-play-circle"></i>Courses in progress</span><strong>{{ $total['process'] }}</strong></div>
                            <div class="mupo-progress-row"><span><i class="fas fa-check-circle"></i>Completed courses</span><strong>{{ $total['complete'] }}</strong></div>
                            <div class="mupo-progress-row"><span><i class="fas fa-chart-line"></i>Estimated progress</span><strong>{{ $overallProgress }}%</strong></div>
                        </div>
                    </div>
                </article>

                <article class="mupo-panel">
                    <div class="mupo-panel-head"><h3>My Certificates</h3>@if(permissionCheck('myCertificate'))<a href="{{ route('myCertificate') }}">View All &nbsp;→</a>@endif</div>
                    <div class="mupo-cert-body">
                        <div class="mupo-cert-empty"><span class="mupo-cert-icon"><i class="fas fa-award"></i></span><div><strong>{{ $myCertificateNumber ? $myCertificateNumber.' certificate(s) earned' : 'No certificates earned yet.' }}</strong><p>{{ $myCertificateNumber ? 'View and download your available certificates.' : 'Complete your training programme to unlock your certificate.' }}</p></div></div>
                    </div>
                </article>
            </div>

            <div class="mupo-stack">
                <article class="mupo-panel">
                    <div class="mupo-panel-head"><h3>Learning Actions</h3></div>
                    <div class="mupo-activity-body">
                        @if(permissionCheck('myQuizzes'))<a href="{{ route('myQuizzes') }}" class="mupo-activity-item"><span class="mupo-activity-icon"><i class="far fa-file-alt red"></i></span><span><strong>Assessments / Quizzes</strong><p>View your available assessments and quiz activity.</p></span></a>@endif
                        @if(permissionCheck('myClasses'))<a href="{{ route('myClasses') }}" class="mupo-activity-item"><span class="mupo-activity-icon"><i class="fas fa-video"></i></span><span><strong>Live Classes</strong><p>Check scheduled virtual or live class sessions.</p></span></a>@endif
                        @if($activeCourse)<a href="{{ route('continueCourse', [$activeCourse->slug]) }}" class="mupo-activity-item"><span class="mupo-activity-icon"><i class="fas fa-book-open"></i></span><span><strong>Continue: {{ $activeCourse->title }}</strong><p>Pick up where you left off.</p></span></a>@endif
                    </div>
                </article>

                <article class="mupo-panel">
                    <div class="mupo-panel-head"><h3>Recent Activity</h3></div>
                    <div class="mupo-activity-body">
                        @forelse($enrolledCourses->take(2) as $enrollment)
                            @if($enrollment->course)
                                <div class="mupo-activity-item"><span class="mupo-activity-icon"><i class="far fa-play-circle"></i></span><span><strong>{{ $enrollment->course->title }}</strong><p>{{ $enrollment->last_view_at ? 'Last viewed '.showDate($enrollment->last_view_at) : 'Enrolled and ready to learn' }}</p></span></div>
                            @endif
                        @empty
                            <div class="mupo-empty"><i class="far fa-clock"></i>No recent learning activity yet.</div>
                        @endforelse
                    </div>
                </article>
            </div>
        </section>

        <section class="mupo-dashboard-footer">
            <div class="mupo-dashboard-quote">“Education is the most powerful weapon which you can use to change the world.”<small>— Nelson Mandela</small></div>
            <div class="mupo-feature-mini"><span><i class="fas fa-graduation-cap"></i>Quality Education</span><span><i class="fas fa-users"></i>Expert Trainers</span><span><i class="fas fa-cog"></i>Practical Learning</span><span><i class="fas fa-award"></i>Accredited Programs</span></div>
            <a href="{{ route('courses') }}" class="mupo-explore-btn">Explore More Courses &nbsp;→</a>
        </section>
    </div>
</div>
