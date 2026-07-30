@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('common.Reports')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-my-report-course-page-section/>
    <x-my-report-quiz-page-section/>
@endsection
