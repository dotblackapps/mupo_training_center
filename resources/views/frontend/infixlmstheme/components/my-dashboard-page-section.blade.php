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
    $firstName = trim(explode(' ', Auth::user()->name)[0] ?? Auth::user()->name);
    $lastActivity = $activeEnrollment && $activeEnrollment->last_view_at ? showDate($activeEnrollment->last_view_at) : 'Ready when you are';
@endphp

<style>
.mupo-dashboard{max-width:1500px;margin:0 auto;color:var(--mupo-text)}
.mupo-dashboard a{text-decoration:none}
.mupo-hero{
    min-height:214px;border-radius:10px;overflow:hidden;position:relative;padding:28px 31px;
    background:linear-gradient(90deg,rgba(6,27,58,.99) 0%,rgba(6,27,58,.92) 44%,rgba(6,27,58,.30) 74%,rgba(6,27,58,.08) 100%),
    url('{{ asset('mupo/assets/images/bulb.jpg') }}') center/cover no-repeat;color:#fff;display:flex;align-items:center
}
.mupo-hero-content{position:relative;z-index:2;max-width:720px}
.mupo-hero-kicker{color:#ff343c;font-size:11px;font-weight:900;letter-spacing:1.8px;text-transform:uppercase;margin-bottom:8px}
.mupo-hero h1{font-size:34px!important;line-height:1.06;color:#fff!important;margin:0 0 9px;font-weight:800}
.mupo-hero-course{font-size:16px;font-weight:800;color:#fff;margin-bottom:5px}
.mupo-hero-progress-copy{font-size:12px;color:rgba(255,255,255,.82);margin-bottom:17px}
.mupo-hero-btn{display:inline-flex;align-items:center;gap:9px;background:var(--mupo-red);color:#fff!important;padding:11px 19px;border-radius:6px;font-size:11px;font-weight:800}
.mupo-hero:after{
    content:"PROFESSIONAL\A LEARNING\A FOR A BRIGHTER\A TOMORROW.";white-space:pre;position:absolute;right:26px;bottom:24px;
    border-left:3px solid var(--mupo-red);padding-left:14px;font-size:11px;line-height:1.45;letter-spacing:1.8px;font-weight:800;color:#fff
}
.mupo-kpi-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-top:13px}
.mupo-kpi{
    background:#fff;border:1px solid var(--mupo-line);border-radius:9px;padding:15px 17px;min-height:105px;
    display:flex;align-items:flex-start;gap:13px;box-shadow:0 4px 14px rgba(6,27,58,.03)
}
.mupo-kpi-icon{
    width:34px;height:34px;border-radius:7px;background:#fff0f1;color:var(--mupo-red);display:grid;place-items:center;
    font-size:15px;flex:0 0 auto
}
.mupo-kpi-content label{display:block;color:var(--mupo-text);font-size:10px;font-weight:800;margin:1px 0 5px}
.mupo-kpi-content strong{display:block;color:var(--mupo-text);font-size:25px;line-height:1;font-weight:800}
.mupo-kpi-content p{font-size:9px;color:#8a94a3;margin:5px 0 0}
.mupo-kpi-progress{min-width:0;flex:1}
.mupo-kpi-track,.mupo-progress-track{height:7px;background:#e8ecf1;border-radius:10px;overflow:hidden;margin-top:7px}
.mupo-kpi-track span,.mupo-progress-track span{display:block;height:100%;background:var(--mupo-red);border-radius:10px}
.mupo-primary-grid{display:grid;grid-template-columns:1.35fr .95fr;gap:12px;margin-top:12px}
.mupo-secondary-grid{display:grid;grid-template-columns:1.35fr .95fr;gap:12px;margin-top:12px}
.mupo-panel{background:#fff;border:1px solid var(--mupo-line);border-radius:9px;box-shadow:0 4px 14px rgba(6,27,58,.03);overflow:hidden}
.mupo-panel-head{height:46px;display:flex;align-items:center;justify-content:space-between;padding:0 15px;border-bottom:1px solid var(--mupo-line)}
.mupo-panel-head h3{font-size:14px!important;color:var(--mupo-text)!important;margin:0;font-weight:800}
.mupo-panel-head a{font-size:10px;color:var(--mupo-red)!important;font-weight:700}
.mupo-continue-body{padding:13px;display:grid;grid-template-columns:155px 1fr;gap:16px}
.mupo-course-thumb{min-height:205px;border-radius:7px;background:center/cover no-repeat;position:relative;overflow:hidden}
.mupo-course-thumb:before{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(6,27,58,.04),rgba(6,27,58,.18))}
.mupo-course-thumb span{position:absolute;top:9px;left:9px;background:var(--mupo-navy);color:#fff;padding:5px 8px;border-radius:5px;font-size:8px;font-weight:700}
.mupo-course-info h2{font-size:17px!important;line-height:1.24;color:var(--mupo-text)!important;margin:2px 0 7px;font-weight:800}
.mupo-level{display:inline-block;font-size:9px;background:#eef2f7;border-radius:4px;padding:4px 7px;color:#4c5b70;margin-bottom:9px}
.mupo-course-progress-copy{font-size:10px;color:var(--mupo-muted);margin-bottom:2px}
.mupo-course-details{margin:12px 0;display:grid;gap:7px}
.mupo-course-detail{display:flex;align-items:flex-start;gap:8px;font-size:10px;color:var(--mupo-muted)}
.mupo-course-detail i{color:var(--mupo-navy);width:14px;margin-top:2px}
.mupo-course-detail strong{display:block;color:var(--mupo-text);font-size:10px}
.mupo-primary-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--mupo-red)!important;color:#fff!important;border-radius:6px;padding:10px 16px;font-size:10px;font-weight:800;width:100%}
.mupo-upnext-body,.mupo-recent-body{padding:4px 15px}
.mupo-upnext-item,.mupo-recent-item{display:grid;grid-template-columns:32px 1fr auto;gap:10px;align-items:center;padding:12px 0;border-bottom:1px solid #edf0f4}
.mupo-upnext-item:last-child,.mupo-recent-item:last-child{border-bottom:0}
.mupo-item-icon{width:32px;height:32px;border-radius:50%;background:#f1f4f8;color:var(--mupo-navy);display:grid;place-items:center;font-size:13px}
.mupo-item-icon.red{background:#fff0f1;color:var(--mupo-red)}
.mupo-upnext-item strong,.mupo-recent-item strong{display:block;color:var(--mupo-text);font-size:10px}
.mupo-upnext-item p,.mupo-recent-item p{margin:2px 0 0;color:var(--mupo-muted);font-size:9px;line-height:1.35}
.mupo-item-action{font-size:9px;color:var(--mupo-red)!important;font-weight:700;white-space:nowrap}
.mupo-status-pill{font-size:8px;color:#59687b;background:#f0f3f6;padding:4px 7px;border-radius:12px;white-space:nowrap}
.mupo-progress-body{padding:15px}
.mupo-progress-main{display:flex;align-items:center;justify-content:space-between;gap:15px}
.mupo-progress-main strong{font-size:11px;color:var(--mupo-text)}
.mupo-progress-main .pct{font-size:15px;font-weight:800;color:var(--mupo-text)}
.mupo-progress-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:16px;border-top:1px solid var(--mupo-line);padding-top:14px}
.mupo-progress-stat{padding:0 15px;border-right:1px solid var(--mupo-line)}
.mupo-progress-stat:first-child{padding-left:0}.mupo-progress-stat:last-child{border-right:0}
.mupo-progress-stat strong{display:block;font-size:15px;color:var(--mupo-text)}
.mupo-progress-stat span{display:block;font-size:8px;color:var(--mupo-muted);margin-top:3px}
.mupo-progress-stat i{color:var(--mupo-navy);margin-right:6px}
.mupo-recent-item{grid-template-columns:30px 1fr auto;padding:10px 0}
.mupo-recent-time{font-size:8px;color:#8792a2;text-align:right}
.mupo-empty{padding:28px 18px;text-align:center;color:var(--mupo-muted);font-size:11px}
.mupo-empty i{font-size:23px;color:#b6c0cc;margin-bottom:9px;display:block}
@media(max-width:1199px){.mupo-kpi-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:991px){.mupo-primary-grid,.mupo-secondary-grid{grid-template-columns:1fr}.mupo-hero:after{display:none}}
@media(max-width:640px){
    .mupo-hero{min-height:230px;padding:22px 18px;background-position:62% center}.mupo-hero h1{font-size:28px!important}
    .mupo-kpi-grid{grid-template-columns:1fr 1fr;gap:8px}.mupo-kpi{padding:12px;min-height:95px}
    .mupo-continue-body{grid-template-columns:1fr}.mupo-course-thumb{min-height:185px}
    .mupo-progress-stats{grid-template-columns:1fr 1fr;row-gap:14px}.mupo-progress-stat:nth-child(2){border-right:0}
}
</style>

<div class="main_content_iner">
    <div class="mupo-dashboard">
        <section class="mupo-hero">
            <div class="mupo-hero-content">
                <div class="mupo-hero-kicker">Welcome back, {{ strtoupper($firstName) }}</div>
                <h1>Continue where you left off.</h1>

                @if($activeCourse)
                    <div class="mupo-hero-course">{{ $activeCourse->title }}</div>
                    <div class="mupo-hero-progress-copy">{{ $activeProgress }}% complete &nbsp;•&nbsp; Last activity {{ $lastActivity }}</div>
                    <a href="{{ route('continueCourse', [$activeCourse->slug]) }}" class="mupo-hero-btn">
                        Continue Learning <i class="fas fa-arrow-right"></i>
                    </a>
                @else
                    <div class="mupo-hero-course">Your learning journey starts here.</div>
                    <div class="mupo-hero-progress-copy">Choose a course and begin learning at your own pace.</div>
                    <a href="{{ route('courses') }}" class="mupo-hero-btn">Explore Courses <i class="fas fa-arrow-right"></i></a>
                @endif
            </div>
        </section>

        <section class="mupo-kpi-grid" aria-label="Learning overview">
            <article class="mupo-kpi">
                <span class="mupo-kpi-icon"><i class="fas fa-graduation-cap"></i></span>
                <div class="mupo-kpi-content"><label>Courses Enrolled</label><strong>{{ $total['total'] }}</strong><p>Total active enrolments</p></div>
            </article>
            <article class="mupo-kpi">
                <span class="mupo-kpi-icon"><i class="fas fa-play"></i></span>
                <div class="mupo-kpi-content"><label>Courses in Progress</label><strong>{{ $total['process'] }}</strong><p>Keep going!</p></div>
            </article>
            <article class="mupo-kpi">
                <span class="mupo-kpi-icon"><i class="fas fa-check-circle"></i></span>
                <div class="mupo-kpi-content"><label>Completed Courses</label><strong>{{ $total['complete'] }}</strong><p>Courses completed</p></div>
            </article>
            <article class="mupo-kpi">
                <span class="mupo-kpi-icon"><i class="fas fa-chart-bar"></i></span>
                <div class="mupo-kpi-content mupo-kpi-progress">
                    <label>Overall Progress</label><strong>{{ $overallProgress }}%</strong>
                    <div class="mupo-kpi-track"><span style="width:{{ $overallProgress }}%"></span></div>
                    <p>Across all your courses</p>
                </div>
            </article>
        </section>

        <section class="mupo-primary-grid">
            <article class="mupo-panel" id="continue-learning">
                <div class="mupo-panel-head">
                    <h3>Continue Learning</h3>
                    @if(permissionCheck('myCourses'))<a href="{{ route('myCourses') }}">View My Courses &nbsp;→</a>@endif
                </div>

                @if($activeCourse)
                    <div class="mupo-continue-body">
                        <div class="mupo-course-thumb" style="background-image:url('{{ getCourseImage($activeCourse->image) }}')">
                            <span>In Progress</span>
                        </div>
                        <div class="mupo-course-info">
                            <h2>{{ $activeCourse->title }}</h2>
                            @if($activeCourse->courseLevel)<span class="mupo-level">{{ $activeCourse->courseLevel->title }}</span>@endif
                            <div class="mupo-course-progress-copy">{{ $activeProgress }}% complete</div>
                            <div class="mupo-progress-track"><span style="width:{{ $activeProgress }}%"></span></div>

                            <div class="mupo-course-details">
                                <div class="mupo-course-detail">
                                    <i class="far fa-bookmark"></i>
                                    <span><strong>Up next</strong>Continue your current lesson</span>
                                </div>
                                <div class="mupo-course-detail">
                                    <i class="far fa-clock"></i>
                                    <span><strong>Last activity</strong>{{ $lastActivity }}</span>
                                </div>
                            </div>

                            <a class="mupo-primary-btn" href="{{ route('continueCourse', [$activeCourse->slug]) }}">
                                Continue Learning <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="mupo-empty">
                        <i class="fas fa-book-open"></i>
                        <strong>No course currently in progress.</strong><br>
                        Choose a course to begin your learning journey.
                    </div>
                @endif
            </article>

            <article class="mupo-panel">
                <div class="mupo-panel-head">
                    <h3>Up Next</h3>
                    @if(permissionCheck('myCourses'))<a href="{{ route('myCourses') }}">View All &nbsp;→</a>@endif
                </div>
                <div class="mupo-upnext-body">
                    @if($activeCourse)
                        <div class="mupo-upnext-item">
                            <span class="mupo-item-icon"><i class="far fa-book-open"></i></span>
                            <div><strong>Continue lesson</strong><p>{{ $activeCourse->title }}</p></div>
                            <a class="mupo-item-action" href="{{ route('continueCourse', [$activeCourse->slug]) }}">Continue →</a>
                        </div>
                    @endif

                    @if(permissionCheck('myQuizzes'))
                        <div class="mupo-upnext-item">
                            <span class="mupo-item-icon red"><i class="far fa-file-alt"></i></span>
                            <div><strong>Assessment</strong><p>Review your available quizzes and assessments.</p></div>
                            <a class="mupo-item-action" href="{{ route('myQuizzes') }}">Open →</a>
                        </div>
                    @endif

                    @if(permissionCheck('myClasses'))
                        <div class="mupo-upnext-item">
                            <span class="mupo-item-icon"><i class="fas fa-video"></i></span>
                            <div><strong>Live class</strong><p>Check your scheduled learning sessions.</p></div>
                            <a class="mupo-item-action" href="{{ route('myClasses') }}">View →</a>
                        </div>
                    @endif
                </div>
            </article>
        </section>

        <section class="mupo-secondary-grid">
            <article class="mupo-panel" id="learning-progress">
                <div class="mupo-panel-head">
                    <h3>Your Progress — {{ $activeCourse ? $activeCourse->title : 'Overall Learning' }}</h3>
                    @if(permissionCheck('myCourses'))<a href="{{ route('myCourses') }}">View Details &nbsp;→</a>@endif
                </div>
                <div class="mupo-progress-body">
                    <div class="mupo-progress-main">
                        <strong>Overall course progress</strong>
                        <span class="pct">{{ $activeCourse ? $activeProgress : $overallProgress }}%</span>
                    </div>
                    <div class="mupo-progress-track">
                        <span style="width:{{ $activeCourse ? $activeProgress : $overallProgress }}%"></span>
                    </div>

                    <div class="mupo-progress-stats">
                        <div class="mupo-progress-stat"><strong><i class="fas fa-graduation-cap"></i>{{ $total['total'] }}</strong><span>Courses enrolled</span></div>
                        <div class="mupo-progress-stat"><strong><i class="fas fa-play-circle"></i>{{ $total['process'] }}</strong><span>In progress</span></div>
                        <div class="mupo-progress-stat"><strong><i class="fas fa-check-circle"></i>{{ $total['complete'] }}</strong><span>Completed</span></div>
                        <div class="mupo-progress-stat"><strong><i class="fas fa-award"></i>{{ $myCertificateNumber }}</strong><span>Certificates earned</span></div>
                    </div>
                </div>
            </article>

            <article class="mupo-panel">
                <div class="mupo-panel-head"><h3>Recent Activity</h3></div>
                <div class="mupo-recent-body">
                    @forelse($enrolledCourses->take(3) as $enrollment)
                        @if($enrollment->course)
                            <div class="mupo-recent-item">
                                <span class="mupo-item-icon"><i class="far fa-play-circle"></i></span>
                                <div>
                                    <strong>{{ $enrollment->course->title }}</strong>
                                    <p>{{ $enrollment->last_view_at ? 'Learning activity recorded' : 'Enrolled and ready to learn' }}</p>
                                </div>
                                <span class="mupo-recent-time">{{ $enrollment->last_view_at ? showDate($enrollment->last_view_at) : 'Ready' }}</span>
                            </div>
                        @endif
                    @empty
                        <div class="mupo-empty"><i class="far fa-clock"></i>No recent learning activity yet.</div>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
</div>
