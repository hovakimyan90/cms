@extends('site.layout')
@if($page['meta_desc'])
@section('meta_desc')
    {{$page['meta_desc']}}
@stop
@endif
@if($page['meta_keys'])
@section('meta_keys')
    {{$page['meta_keys']}}
@stop
@endif
@section('title')
    {{$page['name']}}
@stop
@section('content')
    @if(!$content)
        <p>No Content</p>
    @else
        <p>{!! $content->content !!}</p>
    @endif
@stop