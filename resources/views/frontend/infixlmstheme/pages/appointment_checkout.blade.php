@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('common.Checkout')}}
@endsection
@section('css')
    <link rel="stylesheet"
          href="{{assetPath('modules/appointment/frontend/css/appointment.css') }}{{assetVersion()}}"/>
@endsection
@section('mainContent')

    <x-appointment-checkout-page-section :request="$request"/>

@endsection
@section('js')
    <script src="{{assetPath('frontend/infixlmstheme/js/select2.min.js')}}"></script>
    <script src="{{assetPath('frontend/infixlmstheme/js/checkout.js')}}"></script>
    <script src="{{assetPath('frontend/infixlmstheme/js/city.js')}}"></script>
@endsection
