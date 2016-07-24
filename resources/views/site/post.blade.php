@extends('site.layout')
@section('content')
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