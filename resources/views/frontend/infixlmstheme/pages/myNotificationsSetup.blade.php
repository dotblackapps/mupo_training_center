@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('setting.Notification Setup')}}
@endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-notification-setup/>
@endsection
