@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} |
    @if( routeIs('myclass'))
        {{__('class.My Class')}}
    @else
        {{__('class.My Class')}}
    @endif
@endsection
@section('css') @endsection
@section('js')

@endsection

@section('mainContent')

    <x-my-invoice-list/>

@endsection
