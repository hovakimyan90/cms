@extends('site.layout')
@section('content')
    @if(!$posts->total())
        <p>No Posts</p>
    @else
        <form method="post">
            <input type="text" placeholder="Search" name="search">
            <input type="submit" value="Search">
        </form>
        @foreach($posts as $post)
            <a href="/news/{{$post['alias']}}" title="{{$post['title']}}">
                <h1>{{$post['title']}}</h1>
            </a>
            @if($post['image'])
                <img src="/uploads/{{$post['image']}}" alt="{{$post['title']}}" title="{{$post['title']}}"/>
            @else
                <img src="/assets/site/images/320x160.png" alt="GH CMS" title="GH CMS"/>
            @endif
            <p>{!!str_limit(strip_tags($post['content']),20,'...')!!}</p>
            <p>{{$post->author->first_name}} {{$post->author->last_name}}</p>
            <p>{{$post['created_at']->format('d/m/Y')}}</p>
        @endforeach
        {!! $posts->render() !!}
    @endif
@stop