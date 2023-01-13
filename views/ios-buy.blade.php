@extends('hanoivip::layouts.app')

@section('title', 'Ios install details..')

@section('content')

@if (!empty($error))
<p style="color: red;">{{$error}}</p>
@endif

<p>To buy {{$days}} days usage, you need {{$cost}} web coin!</p>
<form method="post" action="{{route('ios.buy')}}">
{{ csrf_field() }}
	<button type="submit">Buy it!</button>
</form>

<a href="{{route('webtopup')}}">Topup</a>

@endsection