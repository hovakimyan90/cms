@extends('site.layout')
@section('content')
    <a href="/post/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create new post
    </a>
    <form>
        <div class="input-group">
            <input type="text" class="form-control input-lg" name="search" placeholder="Search for something..."
                   value="{{old('search')}}">

            <div class="input-group-btn">
                <button type="submit" class="btn btn-lg btn-primary btn-icon">
                    Search
                    <i class="entypo-search"></i>
                </button>
            </div>
        </div>
    </form>
    <br/>
    @if(!$posts->total())
        <p>No Posts</p>
    @else
        {!! csrf_field() !!}
        <button class="btn btn-danger posts_delete_all"><i class="glyphicon glyphicon-trash"></i> Delete</button>
        <a href="/post/export" class="btn btn-primary export_excel"><i
                    class="entypo-export"></i>
            Export Excel</a>
        <table class="table table-striped posts">
            <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>Name</th>
                <th>Alias</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Category</th>
                <th>Views</th>
                <th>Status</th>
                <th>Publish</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td><input type="checkbox" data-id="{{$post['id']}}" class="item"></td>
                    <td>{{$post['title']}}</td>
                    <td>{{$post['alias']}}</td>
                    <td>
                        @if(!empty($post['image']))
                            <img src="/uploads/{{$post['image']}}"/>
                        @else
                            <p>None</p>
                        @endif
                    </td>
                    <td>
                        @if(!$post->tags->isEmpty())
                            @foreach($post->tags as $tag)
                                <span>{{$tag['name']}}</span>
                            @endforeach
                        @else
                            <p>None</p>
                        @endif
                    </td>
                    <td>@if(empty($post['category_id']))
                            None @else {{$post->category->name}}@endif</td>
                    <td>{{$post->visits()->count()}}</td>
                    <td>
                        @if($post['approve']==1)
                            Approved
                        @else
                            Not approved
                        @endif
                    </td>
                    <td>@if($post['publish']==1) Published  @else Unpublished @endif</td>
                    <td><a href="/post/edit/{{$post['id']}}"
                           class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <button class="btn btn-danger delete" data-id="{{$post['id']}}"><i
                                    class="glyphicon glyphicon-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $posts->render() !!}
    @endif
@stop