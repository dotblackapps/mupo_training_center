@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{__('blog.My Blogs')}}
@endsection
@section('css')
    <link rel="stylesheet" href="{{assetPath('modules/blog/frontend.css')}}{{assetVersion()}}"/>
@endsection
@section('js') @endsection

@section('mainContent')
    <x-my-blog-page-section/>
@endsection
