@extends(theme('layouts.mupo'))
@section('title', (Settings('site_title') ?: 'Mupo Training Center') . ' | Courses')
@section('mainContent')
@php
    $courseQuery = \Modules\CourseSetting\Entities\Course::with(['category','courseLevel','user'])
        ->where('status', 1)
        ->where('type', 1);

    if (request('search')) {
        $courseQuery->where('title', 'like', '%' . request('search') . '%');
    }

    if (request('category') && request('category') !== 'all') {
        $courseQuery->where('category_id', request('category'));
    }

    if (request('level') && request('level') !== 'all') {
        $courseQuery->where('level', request('level'));
    }

    $courses = $courseQuery->latest()->paginate(12)->appends(request()->query());
    $categories = \Modules\CourseSetting\Entities\Category::where('status', 1)->orderBy('position_order')->get();
    $levels = \Modules\CourseSetting\Entities\CourseLevel::orderBy('title')->get();
@endphp
<section class="page-hero">
  <div><small>Training Programmes</small><h1>Courses</h1><p>Browse Mupo skills programmes, occupational certificates and short courses directly from the InfixLMS database.</p></div>
</section>
<section class="section">
  <div class="section-title"><small>Find a course</small><h2>Find the right programme</h2></div>
  <form method="GET" action="{{ route('courses') }}" class="filters">
    <label class="filter-label">Search<input type="search" name="search" value="{{ request('search') }}" placeholder="Search courses..."></label>
    <label class="filter-label">Category
      <select name="category">
        <option value="all">All Categories</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
      </select>
    </label>
    <label class="filter-label">Level
      <select name="level">
        <option value="all">All Levels</option>
        @foreach($levels as $level)
          <option value="{{ $level->id }}" {{ request('level') == $level->id ? 'selected' : '' }}>{{ $level->title }}</option>
        @endforeach
      </select>
    </label>
    <button class="btn" type="submit">Search</button>
  </form>
  <div class="category-buttons">
    <a class="{{ !request('category') || request('category') == 'all' ? 'active' : '' }}" href="{{ route('courses') }}">All Courses</a>
    @foreach($categories->take(5) as $category)
      <a class="{{ request('category') == $category->id ? 'active' : '' }}" href="{{ route('courses', ['category' => $category->id]) }}">{{ $category->name }}</a>
    @endforeach
  </div>
  <div class="course-grid">
    @forelse($courses as $course)
      <article class="course-card">
        <div class="course-img">
          @if(!empty($course->thumbnail))
            <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}">
          @else
            <i class="fa-solid fa-graduation-cap"></i>
          @endif
        </div>
        <div class="course-body">
          <h3>{{ $course->title }}</h3>
          <p>{{ \Illuminate\Support\Str::limit(strip_tags($course->about ?? $course->description ?? 'Professional Mupo Training Center course.'), 110) }}</p>
          <div class="course-meta">
            <span><strong>Category:</strong> {{ optional($course->category)->name ?: 'Training' }}</span>
            <span><strong>Level:</strong> {{ optional($course->courseLevel)->title ?: 'Available' }}</span>
            <span><strong>Instructor:</strong> {{ optional($course->user)->name ?: 'Mupo Training Center' }}</span>
          </div>
          <div class="course-actions">
            <a class="view" href="{{ route('courseDetailsView', [$course->slug]) }}">View Details</a>
            <a class="apply" href="{{ route('courseDetailsView', [$course->slug]) }}">Apply Now</a>
          </div>
        </div>
      </article>
    @empty
      <div class="mupo-course-empty">No courses found. Add or publish courses in InfixLMS and they will display here automatically.</div>
    @endforelse
  </div>
  <div class="mupo-course-pagination">{{ $courses->links() }}</div>
</section>
<section class="cta"><div><h2>Need help choosing a course?</h2><p>Our advisors can guide you to the right programme.</p></div><a href="{{ route('contact') }}" class="btn">Enquire Now</a></section>
@endsection
