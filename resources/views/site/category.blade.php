@extends('site.layout')
@section('content')
    <form>
        <input type="text" placeholder="Search" name="search" value="{{old('search')}}">
        <select name="tag">
            <option value="">Select Tag</option>
            @foreach($tags as $tag)
                <option value="{{$tag->id}}" @if(old('tag')==$tag->id) selected @endif>{{$tag->name}}</option>
            @endforeach
        </select>
        <input type="submit" value="Search">
    </form>
    @if(!$posts->total())
        <p>No Posts</p>
    @else
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