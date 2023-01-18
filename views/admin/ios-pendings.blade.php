@extends('hanoivip::admin.layouts.admin')

@section('title', 'iOS install requests..')

@section('content')

@foreach ($pendings as $record)
	User: {{ $record->user_id }}
	UDID: {{ $record->udid }}
	<form method="post" action="{{ route('ecmin.ios.invalid') }}">
	{{ csrf_field() }}
		<input type="hidden" id="udid" name="udid" value="{{$record->udid}}" />
		<button type="submit">Invalid</button>
	</form>
	<br/>
@endforeach

<a href="{{ route('ecmin.ios.finish') }}">OK, done!!</a>

@endsection