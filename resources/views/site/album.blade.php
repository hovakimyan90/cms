@extends('site.layout')
@if($album['meta_desc'])
@section('meta_desc')
    {{$album['meta_desc']}}
@stop
@endif
@if($album['meta_keys'])
@section('meta_keys')
    {{$album['meta_keys']}}
@stop
@endif
@section('title')
    {{$album['name']}}
@stop
@section('content')
    <form>
        <input type="text" placeholder="Search" name="search" value="{{old('search')}}">
        <input type="submit" value="Search">
    </form>
    @if(!$images->total())
        <p>No Posts</p>
    @else
        @foreach($images as $image)
            <a href="{{$image['link']}}" title="{{$image['title']}}">
                <img src="{{asset('storage/uploads/'.$image['image'])}}"/>
            </a>
            <p>{{$image['title']}}</p>
        @endforeach
        {!! $images->render() !!}
    @endif
@stop