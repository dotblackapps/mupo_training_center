<header class="mupo-site-header">
  <div class="mupo-topbar">
    <div class="mupo-topbar__inner">
      <a href="tel:0120042004"><i class="fa-solid fa-phone"></i><span>012 004 2004 / 084 750 7013</span></a>
      <a href="mailto:admin@mupotrainingcenter.co.za"><i class="fa-solid fa-envelope"></i><span>admin@mupotrainingcenter.co.za</span></a>
      <a href="https://www.mupotrainingcenter.co.za" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-globe"></i><span>www.mupotrainingcenter.co.za</span></a>
    </div>
  </div>
  <div class="mupo-navbar">
    <div class="mupo-navbar__inner">
      <a href="{{ route('frontendHomePage') }}" class="mupo-logo" aria-label="Mupo Training Center Home">
        <img src="{{ asset('mupo/assets/images/mupo-logo_1.jpeg') }}" alt="Mupo Training Center Logo">
      </a>
      <button class="mupo-menu-toggle" type="button" aria-label="Open menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
      <nav class="mupo-nav" aria-label="Main navigation">
        <a href="{{ route('frontendHomePage') }}" class="{{ request()->routeIs('frontendHomePage') ? 'active-page' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active-page' : '' }}">About Us</a>
        <a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') || request()->routeIs('courseDetailsView') ? 'active-page' : '' }}">Courses</a>
        <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active-page' : '' }}">Services</a>
        <a href="{{ route('corporateTraining') }}" class="{{ request()->routeIs('corporateTraining') ? 'active-page' : '' }}">Corporate Training</a>
        <a href="{{ route('accreditation') }}" class="{{ request()->routeIs('accreditation') ? 'active-page' : '' }}">Accreditation</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active-page' : '' }}">Contact Us</a>
      </nav>
      <div class="mupo-auth">
        @auth
          <a href="{{ route('dashboard') }}" class="mupo-auth__login">Dashboard</a>
        @else
          <a href="{{ route('login') }}" target="_blank" rel="noopener noreferrer" class="mupo-auth__login">Login</a>
          @if(Settings('student_reg')==1 && saasPlanCheck('student')==false)
            <a href="{{ route('register') }}" target="_blank" rel="noopener noreferrer" class="mupo-auth__signup">Sign Up</a>
          @endif
        @endauth
      </div>
    </div>
  </div>
</header>
<script>
document.addEventListener('DOMContentLoaded',function(){const t=document.querySelector('.mupo-menu-toggle');const n=document.querySelector('.mupo-nav');if(t&&n){t.addEventListener('click',function(){const o=n.classList.toggle('is-open');t.setAttribute('aria-expanded',o?'true':'false');});}});
</script>
