@extends(theme('layouts.dashboard_master'))

@section('title')
    {{ Settings('site_title') ?: 'MUPO Training Center' }} | My Learning
@endsection

@section('mainContent')
<div class="main_content_iner">
    <main class="mupo-workspace" aria-labelledby="learning-page-title">
        <header class="mupo-workspace-heading">
            <div>
                <span class="mupo-workspace-eyebrow">LEARNING WORKSPACE</span>
                <h1 id="learning-page-title">My Learning</h1>
                <p>Continue your active courses and manage your learning journey.</p>
            </div>
            @if(permissionCheck('myCourses'))
                <a class="mupo-secondary-action" href="{{ route('myCourses') }}"><i class="fas fa-th-large"></i> View My Courses</a>
            @endif
        </header>

        @if($activeCourse)
            @php($featured = $activeCourse)
            <section class="mupo-learning-feature" aria-label="Continue learning">
                <div class="mupo-learning-feature-image" style="background-image:url('{{ getCourseImage($featured['course']->image) }}')">
                    <span>{{ $featured['status_label'] }}</span>
                </div>
                <div class="mupo-learning-feature-content">
                    <span class="mupo-workspace-eyebrow">CONTINUE WHERE YOU LEFT OFF</span>
                    <h2>{{ $featured['course']->title }}</h2>
                    @if($featured['course']->courseLevel && $featured['course']->courseLevel->title)
                        <span class="mupo-level-pill">{{ $featured['course']->courseLevel->title }}</span>
                    @endif
                    <div class="mupo-feature-progress-copy">
                        <strong>{{ $featured['percentage'] }}% complete</strong>
                        <span>{{ $featured['completed_lessons'] }} of {{ $featured['total_lessons'] }} lessons</span>
                    </div>
                    <div class="mupo-workspace-progress" role="progressbar" aria-label="{{ $featured['course']->title }} progress" aria-valuenow="{{ $featured['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                        <span style="width:{{ $featured['percentage'] }}%"></span>
                    </div>
                    <div class="mupo-feature-meta">
                        <span><i class="far fa-bookmark"></i><b>Up next:</b> {{ $featured['next_lesson'] ? $featured['next_lesson']->name : 'Course review' }}</span>
                        <span><i class="far fa-clock"></i><b>Last activity:</b> {{ $featured['last_activity'] ? showDate($featured['last_activity']) : 'Ready to begin' }}</span>
                    </div>
                    <a class="mupo-primary-action" href="{{ route('continueCourse', [$featured['course']->slug]) }}">
                        <i class="fas fa-play"></i> {{ $featured['status'] === 'not-started' ? 'Start Course' : 'Continue Learning' }}
                    </a>
                </div>
            </section>
        @endif

        <section class="mupo-summary-grid" aria-label="Learning summary">
            <article><i class="fas fa-play-circle"></i><div><strong>{{ $summary['in_progress'] }}</strong><span>Active courses</span></div></article>
            <article><i class="far fa-circle"></i><div><strong>{{ $summary['not_started'] }}</strong><span>Not started</span></div></article>
            <article><i class="fas fa-check-circle"></i><div><strong>{{ $summary['completed'] }}</strong><span>Completed</span></div></article>
            <article><i class="fas fa-award"></i><div><strong>{{ $summary['certificates'] }}</strong><span>Certificates earned</span></div></article>
        </section>

        <section class="mupo-workspace-panel">
            <div class="mupo-workspace-panel-head">
                <div><h2>All Learning</h2><p>Find and continue any enrolled course.</p></div>
                <div class="mupo-learning-controls">
                    <label class="mupo-search-control"><span class="sr-only">Search enrolled courses</span><i class="fas fa-search"></i><input id="mupoLearningSearch" type="search" placeholder="Search courses…" autocomplete="off"></label>
                    <label><span class="sr-only">Filter courses by status</span><select id="mupoLearningFilter"><option value="all">All courses</option><option value="in-progress">In progress</option><option value="not-started">Not started</option><option value="completed">Completed</option></select></label>
                    <label><span class="sr-only">Sort courses</span><select id="mupoLearningSort"><option value="recent">Recently viewed</option><option value="progress-desc">Highest progress</option><option value="progress-asc">Lowest progress</option><option value="title">Course title</option></select></label>
                </div>
            </div>

            <div class="mupo-learning-list" id="mupoLearningList">
                @forelse($learningCourses as $item)
                    <article class="mupo-learning-card" data-title="{{ strtolower($item['course']->title) }}" data-status="{{ $item['status'] }}" data-progress="{{ $item['percentage'] }}" data-order="{{ $loop->index }}">
                        <div class="mupo-learning-card-image" style="background-image:url('{{ getCourseImage($item['course']->image) }}')"></div>
                        <div class="mupo-learning-card-body">
                            <div class="mupo-card-title-line">
                                <div>
                                    <span class="mupo-status mupo-status-{{ $item['status'] }}">{{ $item['status_label'] }}</span>
                                    <h3>{{ $item['course']->title }}</h3>
                                </div>
                                <strong>{{ $item['percentage'] }}%</strong>
                            </div>
                            <div class="mupo-workspace-progress" role="progressbar" aria-valuenow="{{ $item['percentage'] }}" aria-valuemin="0" aria-valuemax="100"><span style="width:{{ $item['percentage'] }}%"></span></div>
                            <div class="mupo-learning-card-meta">
                                <span><i class="far fa-check-circle"></i>{{ $item['completed_lessons'] }} of {{ $item['total_lessons'] }} lessons</span>
                                <span><i class="far fa-clock"></i>{{ $item['last_activity'] ? showDate($item['last_activity']) : 'Not opened yet' }}</span>
                                @if($item['course']->courseLevel && $item['course']->courseLevel->title)<span><i class="fas fa-signal"></i>{{ $item['course']->courseLevel->title }}</span>@endif
                            </div>
                            <div class="mupo-card-actions">
                                <a class="mupo-primary-action" href="{{ route('continueCourse', [$item['course']->slug]) }}">
                                    {{ $item['status'] === 'completed' ? 'Review Course' : ($item['status'] === 'not-started' ? 'Start Course' : 'Continue Learning') }} <i class="fas fa-arrow-right"></i>
                                </a>
                                @if($item['has_certificate'])
                                    <a class="mupo-text-action" href="{{ route('myCertificate') }}"><i class="fas fa-award"></i> View Certificate</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="mupo-workspace-empty">
                        <i class="fas fa-book-open"></i><h2>You have no active courses yet</h2>
                        <p>Explore MUPO training programmes and begin your learning journey.</p>
                        <a class="mupo-primary-action" href="{{ route('courses') }}">Explore Courses <i class="fas fa-arrow-right"></i></a>
                    </div>
                @endforelse
            </div>
            <div class="mupo-workspace-empty mupo-filter-empty" id="mupoLearningEmpty" hidden>
                <i class="fas fa-search"></i><h2>No courses match your search</h2><p>Change the search term or status filter and try again.</p>
                <button type="button" id="mupoClearLearningFilters" class="mupo-secondary-action">Clear Filters</button>
            </div>
        </section>
    </main>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const list = document.getElementById('mupoLearningList');
    if (!list) return;
    const search = document.getElementById('mupoLearningSearch');
    const filter = document.getElementById('mupoLearningFilter');
    const sort = document.getElementById('mupoLearningSort');
    const empty = document.getElementById('mupoLearningEmpty');
    const cards = Array.from(list.querySelectorAll('.mupo-learning-card'));

    function refresh() {
        const query = search.value.trim().toLowerCase();
        const status = filter.value;
        const mode = sort.value;
        const ordered = cards.slice().sort(function (a, b) {
            if (mode === 'progress-desc') return Number(b.dataset.progress) - Number(a.dataset.progress);
            if (mode === 'progress-asc') return Number(a.dataset.progress) - Number(b.dataset.progress);
            if (mode === 'title') return a.dataset.title.localeCompare(b.dataset.title);
            return Number(a.dataset.order) - Number(b.dataset.order);
        });
        let visible = 0;
        ordered.forEach(function (card) {
            list.appendChild(card);
            const show = (!query || card.dataset.title.includes(query)) && (status === 'all' || card.dataset.status === status);
            card.hidden = !show;
            if (show) visible++;
        });
        empty.hidden = visible !== 0 || cards.length === 0;
    }
    [search, filter, sort].forEach(function (control) { control.addEventListener(control === search ? 'input' : 'change', refresh); });
    document.getElementById('mupoClearLearningFilters').addEventListener('click', function () { search.value = ''; filter.value = 'all'; sort.value = 'recent'; refresh(); search.focus(); });
});
</script>
@endsection
