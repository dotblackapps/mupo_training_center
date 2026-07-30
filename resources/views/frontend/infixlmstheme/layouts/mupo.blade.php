<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @php
        /*
         * MUPO ASSET BASE FIX
         * XAMPP URL: http://localhost/lnfixlms/ needs /lnfixlms/public/mupo/...
         * artisan serve URL: http://127.0.0.1:8000/ needs /mupo/...
         */
        $isArtisanServe = in_array(request()->getPort(), [8000, 8001, 8080]) || str_contains(request()->getHost(), '127.0.0.1');
        $mupoAssetBase = $isArtisanServe ? asset('mupo') : asset('mupo');
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', Settings('site_title') ?: 'Mupo Training Center')</title>
    <meta name="description" content="@yield('meta_description', Settings('meta_description') ?: 'Mupo Training Center online learning platform')">
    <link rel="icon" type="image/png" href="{{ $mupoAssetBase . '/assets/images/mupo-logo_1.jpeg' }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ $mupoAssetBase . '/assets/css/style.css' }}?v={{ time() }}">
    @yield('css')
</head>
<body>
<header class="mupo-site-header">
  <div class="mupo-topbar">
    <div class="mupo-topbar__inner">
      <a href="tel:0120042004"><i class="fa-solid fa-phone"></i><span>012 004 2004 / 084 750 7013</span></a>
      <a href="mailto:admin@mupotrainingcenter.co.za"><i class="fa-solid fa-envelope"></i><span>admin@mupotrainingcenter.co.za</span></a>
      <a href="https://www.mupotrainingcenter.co.za" target="_blank"><i class="fa-solid fa-globe"></i><span>www.mupotrainingcenter.co.za</span></a>
    </div>
  </div>
  <div class="mupo-navbar">
    <div class="mupo-navbar__inner">
      <a href="{{ route('frontendHomePage') }}" class="mupo-logo" aria-label="Mupo Training Center Home">
        <img src="{{ $mupoAssetBase . '/assets/images/mupo-logo_1.jpeg' }}" alt="Mupo Training Center Logo">
      </a>
      <button class="mupo-menu-toggle" type="button" aria-label="Open menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
      <nav class="mupo-nav" aria-label="Main navigation">
        <a href="{{ route('frontendHomePage') }}" class="{{ request()->routeIs('frontendHomePage') ? 'active-page' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active-page' : '' }}">About Us</a>
        <a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') ? 'active-page' : '' }}">Courses</a>
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
  <a href="{{ route('register') }}" target="_blank" rel="noopener noreferrer" class="mupo-auth__signup">Sign Up</a>
@endauth
      </div>
    </div>
  </div>
</header>
<input type="hidden" name="base_url" class="base_url" value="{{ url('/') }}">
<input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">
@yield('mainContent')
<footer class="mupo-footer">
  <div class="mupo-footer__wrap">
    <div class="mupo-footer__about">
      <a href="{{ route('frontendHomePage') }}" class="mupo-footer__logo" aria-label="Mupo Training Center Home">
        <img src="{{ $mupoAssetBase . '/assets/images/mupo-logo_1.jpeg' }}" alt="Mupo Training Center Logo">
      </a>
      <p>Mupo Training Center provides accredited, practical and industry-relevant training solutions for individuals, organisations and corporate teams.</p>
      <div class="mupo-footer__social">
        <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
      </div>
    </div>
    <div class="mupo-footer__links">
      <h3>Quick Links</h3>
      <a href="{{ route('frontendHomePage') }}">Home</a>
      <a href="{{ route('about') }}">About Us</a>
      <a href="{{ route('courses') }}">Courses</a>
      <a href="{{ route('services') }}">Services</a>
      <a href="{{ route('corporateTraining') }}">Corporate Training</a>
      <a href="{{ route('contact') }}">Contact Us</a>
    </div>
    <div class="mupo-footer__links">
      <h3>Training Solutions</h3>
      <a href="{{ route('courses') }}">Security & Protection</a>
      <a href="{{ route('courses') }}">Office Administration</a>
      <a href="{{ route('courses') }}">Data & IT</a>
      <a href="{{ route('courses') }}">Project Management</a>
      <a href="{{ route('services') }}">Skills Development</a>
      <a href="{{ route('accreditation') }}">Accreditation</a>
    </div>
    <div class="mupo-footer__contact">
      <h3>Contact Information</h3>
      <p><i class="fa-solid fa-phone"></i><span>012 004 2004 / 084 750 7013</span></p>
      <p><i class="fa-solid fa-envelope"></i><span>admin@mupotrainingcenter.co.za</span></p>
      <p><i class="fa-solid fa-globe"></i><span>www.mupotrainingcenter.co.za</span></p>
      <p><i class="fa-solid fa-location-dot"></i><span>377 Johannes Ramokhoase Street, Pretoria Central, 0002</span></p>
    </div>
  </div>
  <div class="mupo-footer__bottom">
    <p>Copyright © 2024 Mupo Training Center.All rights reserved | Developed By DotBlack</p>
    <div><a href="{{ url('privacy') }}">Privacy Policy</a><a href="#">Terms & Conditions</a></div>
  </div>
</footer>
<a class="back-top" href="#"><i class="fa-solid fa-arrow-up"></i></a>
<div class="toast" id="toast">Thank you. Your request has been captured.</div>
<script src="{{ $mupoAssetBase . '/assets/js/main.js' }}?v={{ time() }}"></script>
<script src="{{ $mupoAssetBase . '/assets/js/header.js' }}?v={{ time() }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.mupo-menu-toggle');
  const nav = document.querySelector('.mupo-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      const isOpen = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }
});
</script>
@yield('js')
</body>
</html>
