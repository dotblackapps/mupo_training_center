@extends(theme('layouts.dashboard_master'))

@section('title')
    {{ Settings('site_title') ?: 'MUPO Training Center' }} | Learning Progress
@endsection

@section('mainContent')
<div class="main_content_iner">
    <main class="mupo-workspace" aria-labelledby="progress-page-title">
        <header class="mupo-workspace-heading">
            <div>
                <span class="mupo-workspace-eyebrow">PERFORMANCE OVERVIEW</span>
                <h1 id="progress-page-title">Learning Progress</h1>
                <p>Track your course completion, lessons and achievements.</p>
            </div>
            <a class="mupo-secondary-action" href="{{ route('myLearning') }}"><i class="fas fa-book-open"></i> Go to My Learning</a>
        </header>

        <section class="mupo-progress-overview">
            <div class="mupo-progress-score" aria-label="Average progress {{ $summary['average_progress'] }} percent">
                <div class="mupo-progress-ring" style="--mupo-progress:{{ $summary['average_progress'] }}">
                    <span><strong>{{ $summary['average_progress'] }}%</strong><small>Average</small></span>
                </div>
                <div><span class="mupo-workspace-eyebrow">YOUR OVERALL POSITION</span><h2>Average progress across enrolled courses</h2><p>{{ $summary['completed_lessons'] }} of {{ $summary['total_lessons'] }} lessons completed across {{ $summary['total'] }} {{ $summary['total'] === 1 ? 'course' : 'courses' }}.</p></div>
            </div>
            <div class="mupo-progress-kpis">
                <article><i class="fas fa-play-circle"></i><strong>{{ $summary['in_progress'] }}</strong><span>In progress</span></article>
                <article><i class="fas fa-check-circle"></i><strong>{{ $summary['completed'] }}</strong><span>Completed</span></article>
                <article><i class="fas fa-list-ul"></i><strong>{{ $summary['completed_lessons'] }}</strong><span>Lessons finished</span></article>
                <article><i class="fas fa-award"></i><strong>{{ $summary['certificates'] }}</strong><span>Certificates</span></article>
            </div>
        </section>

        <section class="mupo-workspace-panel">
            <div class="mupo-workspace-panel-head">
                <div><h2>Course-by-Course Progress</h2><p>Select a course to see its module breakdown.</p></div>
                <label class="mupo-course-filter"><span class="sr-only">Filter progress by course</span><select id="mupoProgressCourseFilter"><option value="all">All enrolled courses</option>@foreach($learningCourses as $item)<option value="course-{{ $item['course']->id }}">{{ $item['course']->title }}</option>@endforeach</select></label>
            </div>

            <div class="mupo-progress-course-list" id="mupoProgressCourseList">
                @forelse($learningCourses as $item)
                    <details class="mupo-progress-course" data-course="course-{{ $item['course']->id }}" @if($loop->first) open @endif>
                        <summary>
                            <span class="mupo-progress-course-image" style="background-image:url('{{ getCourseImage($item['course']->image) }}')"></span>
                            <span class="mupo-progress-course-copy">
                                <span class="mupo-status mupo-status-{{ $item['status'] }}">{{ $item['status_label'] }}</span>
                                <strong>{{ $item['course']->title }}</strong>
                                <small>{{ $item['completed_lessons'] }} of {{ $item['total_lessons'] }} lessons &nbsp;•&nbsp; {{ $item['last_activity'] ? 'Last active '.showDate($item['last_activity']) : 'Ready to begin' }}</small>
                                <span class="mupo-workspace-progress"><span style="width:{{ $item['percentage'] }}%"></span></span>
                            </span>
                            <span class="mupo-progress-course-percent"><strong>{{ $item['percentage'] }}%</strong><i class="fas fa-chevron-down"></i></span>
                        </summary>
                        <div class="mupo-module-breakdown">
                            <div class="mupo-module-heading"><h3>Module breakdown</h3><a href="{{ route('continueCourse', [$item['course']->slug]) }}">{{ $item['status'] === 'completed' ? 'Review Course' : 'Continue Learning' }} <i class="fas fa-arrow-right"></i></a></div>
                            @forelse($item['modules'] as $module)
                                <div class="mupo-module-row">
                                    <div><strong>{{ $module['title'] ?: 'Course module' }}</strong><span>{{ $module['completed_lessons'] }} of {{ $module['total_lessons'] }} lessons completed</span></div>
                                    <div class="mupo-module-progress"><span class="mupo-workspace-progress"><span style="width:{{ $module['percentage'] }}%"></span></span><strong>{{ $module['percentage'] }}%</strong></div>
                                </div>
                            @empty
                                <div class="mupo-module-empty">Module information is not available for this course yet.</div>
                            @endforelse
                        </div>
                    </details>
                @empty
                    <div class="mupo-workspace-empty"><i class="fas fa-chart-line"></i><h2>No learning progress yet</h2><p>Enrol in a course to begin tracking your progress.</p><a class="mupo-primary-action" href="{{ route('courses') }}">Explore Courses <i class="fas fa-arrow-right"></i></a></div>
                @endforelse
            </div>
        </section>

        @if($learningCourses->isNotEmpty())
        <section class="mupo-workspace-panel">
            <div class="mupo-workspace-panel-head"><div><h2>Recent Learning Activity</h2><p>Your most recently opened courses.</p></div></div>
            <div class="mupo-activity-list">
                @foreach($learningCourses->whereNotNull('last_activity')->take(5) as $item)
                    <div class="mupo-activity-row"><span><i class="far fa-play-circle"></i></span><div><strong>{{ $item['course']->title }}</strong><p>{{ $item['status'] === 'completed' ? 'Course completed' : 'Learning activity recorded' }}</p></div><time>{{ showDate($item['last_activity']) }}</time></div>
                @endforeach
                @if($learningCourses->whereNotNull('last_activity')->isEmpty())<div class="mupo-module-empty">No course activity has been recorded yet.</div>@endif
            </div>
        </section>
        @endif
    </main>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filter = document.getElementById('mupoProgressCourseFilter');
    if (!filter) return;
    const cards = Array.from(document.querySelectorAll('.mupo-progress-course'));
    filter.addEventListener('change', function () {
        cards.forEach(function (card) {
            const show = filter.value === 'all' || card.dataset.course === filter.value;
            card.hidden = !show;
            if (show && filter.value !== 'all') card.open = true;
        });
    });
});
</script>
@endsection
