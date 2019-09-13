@extends('hanoivip::layouts.app')

@section('title', 'Link to install iOS')

@section('content')

<a href="{{__('hanoivip::download.ios-in-house')}}">
<img src="{{asset('img/apple.png')}}" style="width:100px; height: 100px;">Install
</a>

@endsection