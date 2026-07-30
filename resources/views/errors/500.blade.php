@extends('errors.layout')
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'MUPO Training Center'}} | {{ __('Server Error')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
@endsection

@section('message')
    {{ __('Server Error')}}
@endsection
@section('details')
    {{ $exception->getMessage()?$exception->getMessage():trans('frontend.Whoops, something went wrong on our servers') }}
@endsection

