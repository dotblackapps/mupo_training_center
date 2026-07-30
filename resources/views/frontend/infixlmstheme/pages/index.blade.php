@extends(theme('layouts.mupo'))
@section('title', (Settings('site_title') ?: 'Mupo Training Center') . ' | Home')
@section('mainContent')
<section class="hero"><div class="hero-text"><h5>Empowering Minds.</h5><h1>Building Futures.</h1><p>Mupo Training Center delivers accredited, practical, and industry-relevant training programmes that empower individuals and organisations to achieve excellence and growth.</p><a href="{{ route('courses') }}" class="btn">Explore Courses</a><a href="{{ route('contact') }}" class="btn-outline">Download Brochure</a></div><div class="hero-img"></div></section><section class="feature-bar"><div class="feature"><span><i class="fa-solid fa-graduation-cap"></i></span>Quality Education</div><div class="feature"><span><i class="fa-solid fa-chalkboard-user"></i></span>Expert Trainers</div><div class="feature"><span><i class="fa-solid fa-building"></i></span>Practical Learning</div><div class="feature"><span><i class="fa-solid fa-certificate"></i></span>Accredited Programs</div><div class="feature"><span><i class="fa-solid fa-handshake"></i></span>Career Support</div><div class="feature"><span><i class="fa-solid fa-clock"></i></span>Flexible Schedules</div></section><section class="section"><div class="section-title"><small>Our Services</small><h2>Training & Development Solutions</h2></div><div class="grid"><div class="card"><div class="card-icon"><i class="fa-solid fa-users"></i></div><h3>Corporate Training</h3><p>Customised in-house training programmes designed to improve organisational performance.</p></div><div class="card"><div class="card-icon"><i class="fa-solid fa-book-open"></i></div><h3>Professional Development</h3><p>Short courses aimed at improving technical, managerial, and soft skills.</p></div><div class="card"><div class="card-icon"><i class="fa-solid fa-book-open"></i></div><h3>Skills Development</h3><p>Accredited training aligned with national qualification frameworks.</p></div><div class="card"><div class="card-icon"><i class="fa-solid fa-microphone-lines"></i></div><h3>Workshops & Seminars</h3><p>Industry-focused workshops addressing current trends and challenges.</p></div><div class="card"><div class="card-icon"><i class="fa-solid fa-handshake"></i></div><h3>Consultancy Services</h3><p>Advisory and capacity-building solutions for organisations.</p></div><div class="card"><div class="card-icon"><i class="fa-solid fa-headset"></i></div><h3>Learner Support</h3><p>Guidance and support before, during, and after your learning journey.</p></div></div><div class="content-row"><div class="training-list"><div class="section-title"><small>Our Training Areas</small><h2>Popular Programmes</h2></div><ul><li>Security & Safety Training</li><li>Occupational Certificates — NQF Level 05</li><li>Firearm & Competency Training</li><li>PSiRA Grade Training — Grade E to Grade A</li><li>Office Administration & Management</li><li>Data Science & Project Management</li></ul></div><div class="stats-panel"><div class="stat"><h3>5000+</h3><p>Learners Trained</p></div><div class="stat"><h3>50+</h3><p>Courses Offered</p></div><div class="stat"><h3>100+</h3><p>Corporate Clients</p></div><div class="stat"><h3>10+</h3><p>Years of Excellence</p></div></div></div></section>@php
    $featuredCourses = \Modules\CourseSetting\Entities\Course::with(['category','courseLevel'])
        ->where('status', 1)
        ->where('type', 1)
        ->latest()
        ->take(8)
        ->get();
@endphp
<section class="section white">
  <div class="section-title center"><small>Popular Courses</small><h2>Explore Our Online Training Programmes</h2></div>
  <div class="course-grid">
    @forelse($featuredCourses as $course)
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
          </div>
          <div class="course-actions">
            <a class="view" href="{{ route('courseDetailsView', [$course->slug]) }}">View Details</a>
            <a class="apply" href="{{ route('courseDetailsView', [$course->slug]) }}">Apply Now</a>
          </div>
        </div>
      </article>
    @empty
      <div class="mupo-course-empty">No courses are available yet. Add courses from the InfixLMS admin panel and they will appear here automatically.</div>
    @endforelse
  </div>
</section><section class="cta"><div><h2>Ready to Start Your Journey?</h2><p>Invest in skills today and build a stronger future tomorrow.</p></div><a href="{{ route('contact') }}" class="btn">Join Us Today</a></section>
@endsection
