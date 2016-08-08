@extends('site.layout')
@section('title')
    {{$post['title']}}
@stop
@if($post['meta_desc'])
@section('meta_desc')
    {{$post['meta_desc']}}
@stop
@endif
@if($post['meta_keys'])
@section('meta_keys')
    {{$post['meta_keys']}}
@stop
@endif
@if($post['image'])
@section('meta_image')
    {{config('app.url')}}/uploads/fb-{{$post['image']}}
@stop
@endif
@section('content')
    {{$post['meta_desc']}}
    <a href="/post/{{$post['alias']}}" title="{{$post['title']}}">
        <h1>{{$post['title']}}</h1>
    </a>
    @if($post['image'])
        <img src="/uploads/{{$post['image']}}" alt="{{$post['title']}}" title="{{$post['title']}}"/>
    @else
        <img src="/assets/site/images/320x160.png" alt="GH CMS" title="GH CMS"/>
    @endif
    <p>{!!$post['content']!!}</p>
    <p>{{$post->author->first_name}} {{$post->author->last_name}}</p>
    <p>{{$post['created_at']->format('d/m/Y')}}</p>
    <p>{{$post->visits()->count()}}</p>
@stop