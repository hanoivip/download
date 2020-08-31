@extends('hanoivip::layouts.app')

@section('title', 'Open app in ChPlay')

@section('content')

@if (isset($link))

<p>Redirecting..</p>
<script>window.open("{{$link}}");</script>

@else

<p>Our app has not been in ChPlay now! Please try again later or use APK file.<p>

@endif

@endsection