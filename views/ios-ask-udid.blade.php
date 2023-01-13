@extends('hanoivip::layouts.app')

@section('title', 'Ios enter your UDID')

@section('content')

@if (!empty($error))
<p style="color: red;">{{$error}}</p>
@endif

<p>Enter your device ID (TODO: make guidelines here)</p>
<form method="post" action="{{route('ios.udid.do')}}">
{{ csrf_field() }}
	UDID:<input id="udid" name="udid" value="" />
	<button type="submit">OK</button>
</form>


@endsection