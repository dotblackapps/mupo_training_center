@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('frontend.Logged In Devices')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-login-device-page-section/>
@endsection
