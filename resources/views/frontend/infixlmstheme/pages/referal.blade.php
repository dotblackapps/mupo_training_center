@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('communication.Your referral link')}} @endsection
@section('css') @endsection
@section('js')
    <script src="{{ assetPath('frontend/infixlmstheme/js/copy_currency.js') }}"></script>
@endsection
@section('mainContent')
    <x-referal-page-section/>
@endsection
