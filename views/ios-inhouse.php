@extends('hanoivip::layouts.app')

@section('title', 'Link to install iOS ipa file')

@section('content')

@if (isset($link))
<p>Install..</p>
<iframe id="iframe_download" src="{{$link}}"></iframe>
<p>If the isntall doesn't start, <a href={{$link}}>click here</a></p>
@else
<p>Our in-house IPA file is not available now, please contact the supporter and try again!<p>
@endif

@endsection