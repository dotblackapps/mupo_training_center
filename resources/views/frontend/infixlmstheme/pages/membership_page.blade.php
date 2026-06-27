@extends(theme('layouts.master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('membership.Membership')}}
@endsection
@section('css')
    <link href="{{assetPath('frontend/infixlmstheme/css/subscription.css')}}{{assetVersion()}}" rel="stylesheet"/>
@endsection


@section('mainContent')
    <x-breadcrumb :banner="trans('common.N/A')"
                  :title="trans('frontend.Explore Membership Options')"
                  :subTitle="trans('frontend.Membership')"/>


    <x-membership-page-section/>

@endsection
@section('js')
    <script src="{{assetPath('frontend/infixlmstheme/js/subscription.js')}}"></script>
@endsection
