@extends('hanoivip::layouts.app')

@section('title', 'Ios buy success..')

@section('content')

<p>Thank for bought! Redirecting..</p>
<script>
setTimeout(function(){ window.location = "{{route('ios.udid')}}" }, 3000);
</script>

@endsection