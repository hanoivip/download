@extends('hanoivip::layouts.app')

@section('title', 'Ios install details..')

@section('content')

@if (empty($endTime))
	<p>Please kindly wait..The install links will be shown (and send to your email) soon!</p>
@else
	<p>You install is activated at {{\Illuminate\Support\Carbon::parse($beginTime)->format('d/M/Y m:H')}} and will be expired at {{\Illuminate\Support\Carbon::parse($endTime)->format('d/M/Y m:H')}}</p>
	<a href="{{__('hanoivip::download.ios-in-house')}}">Install here</a>
	<a href="{{route('ios.renew')}}">Renew installation</a>
	<a href="{{route('ios.history')}}">Check history</a>
@endif

@endsection