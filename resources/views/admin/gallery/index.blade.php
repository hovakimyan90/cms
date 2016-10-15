@extends('admin.layout')
@section('content')
    <a href="/{{config('app.admin_route_name')}}/gallery/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create new gallery
    </a>
    <br/>
    <br/>
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
    </br>
    @if(!$images->total())
        <p>No Posts</p>
    @else
        {!! csrf_field() !!}
        <button class="btn btn-danger gallery_delete_all"><i class="glyphicon glyphicon-trash"></i> Delete</button>
        <table class="table table-striped gallery_images">
            <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>Title</th>
                <th>Link</th>
                <th>Image</th>
                <th>Album Name</th>
                <th>Publish</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($images as $image)
                <tr>
                    <td><input type="checkbox" data-id="{{$image['id']}}" class="item"></td>
                    <td>{{$image['title']}}</td>
                    <td>{{$image['link']}}</td>
                    <td>
                        @if(!empty($image['image']))
                            <img src="{{asset('storage/uploads/'.$image['image'])}}"/>
                        @else
                            <p>None</p>
                        @endif
                    </td>
                    <td>@if(empty($image['album_id']))
                            None @else {{$image->album->name}}@endif</td>
                    <td>@if($image['publish']==1) Published  @else Unpublished @endif</td>
                    <td><a href="/{{config('app.admin_route_name')}}/gallery/edit/{{$image['id']}}"
                           class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <button class="btn btn-danger delete" data-id="{{$image['id']}}"><i
                                    class="glyphicon glyphicon-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $images->render() !!}
    @endif
@stop