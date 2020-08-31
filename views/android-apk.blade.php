@extends('hanoivip::layouts.app')

@section('title', 'Download apk file')

@section('content')

@if (isset($link))

<p>Downloading..</p>
<iframe id="iframe_download" src="{{$link}}"></iframe>

<p>If the download doesn't start, <a href={{$link}}>click here</a></p>

@else

<p>Direct apk file still not available now, please contact the supporter and try again!<p>

@endif

@endsection