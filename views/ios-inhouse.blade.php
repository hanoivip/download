@extends('hanoivip::layouts.app')

@section('title', 'Link to install iOS ipa file')

@section('content')

@if (isset($error_message))
	<div style="color: black;
    background-color: red;
    border-color: #bee5eb; position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;">
		<p >{{$error_message}}</p>
	</div>
@endif

@if (isset($link))
<p>Install..</p>
<iframe id="iframe_download" src="{{$link}}"></iframe>
<p>If the isntall doesn't start, <a href={{$link}}>click here</a></p>
@else
<p>Our in-house IPA file is not available now, please contact the supporter and try again!<p>
@endif

@endsection