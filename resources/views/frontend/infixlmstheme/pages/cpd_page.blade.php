@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('cpd.My CPD')}}
@endsection

@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <x-cpd/>
@endsection
