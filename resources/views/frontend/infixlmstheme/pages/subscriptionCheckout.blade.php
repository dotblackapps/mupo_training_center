@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('common.Checkout')}}
@endsection
@section('css')
    <link href="{{assetPath('frontend/infixlmstheme/css/select2.min.css')}}{{assetVersion()}}" rel="stylesheet"/>
    <link href="{{assetPath('frontend/infixlmstheme/css/checkout.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection
@section('mainContent')

    <x-subscription-checkout-page-section :request="$request" :plan="$s_plan" :price="$price"/>

@endsection
@section('js')
    <script src="{{assetPath('frontend/infixlmstheme/js/select2.min.js')}}{{assetVersion()}}"></script>
    <script src="{{assetPath('frontend/infixlmstheme/js/checkout.js')}}{{assetVersion()}}"></script>
@endsection
