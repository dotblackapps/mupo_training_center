@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('elibrary.E-Library')}}
@endsection

@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-elibrary/>
@endsection
