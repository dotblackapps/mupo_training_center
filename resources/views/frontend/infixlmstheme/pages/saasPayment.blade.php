@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | @lang('frontendmanage.Payment Method') @endsection
@section('css')
@endsection
@section('mainContent')
    <x-saas-payment-page-section :cart="$cart" :bill="$bill" :plan="$plan"/>
@endsection
@section('js')
@endsection
