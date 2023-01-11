@extends('hanoivip::layouts.app')

@section('title', 'Open app in AppStore')

@section('content')

@if (isset($link))
<p>Redirecting..</p>
<script>window.open("{{$link}}");</script>
@else
<p>Our app has not been in AppStore now! Please try again later or use in-house ipa file.<p>
@endif

@endsection