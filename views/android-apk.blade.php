@extends('hanoivip::layouts.app')

@section('title', 'Link to install apk')

@section('content')

<a href="{{__('hanoivip::download.apk-direct')}}">
<img src="{{asset('img/down.png')}}"/>
Link APK Full (quick)</a>
<br/>

<a href="{{__('hanoivip::download.apk-bk')}}">
<img src="{{asset('img/down.png')}}"/>
Link APK backup (slow)</a>

@endsection