@extends('admin.layout')
@section('content')
    <a href="/{{config('app.admin_route_name')}}/album/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create new album
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
    <br/>
    @if(!$albums->total())
        <p>No Albums</p>
    @else
        {!! csrf_field() !!}
        <button class="btn btn-danger albums_delete_all"><i class="glyphicon glyphicon-trash"></i> Delete</button>
        <a href="/{{config('app.admin_route_name')}}/album/export" class="btn btn-primary export_excel"><i
                    class="entypo-export"></i>
            Export Excel</a>
        <table class="table table-striped albums">
            <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>Name</th>
                <th>Alias</th>
                <th>Parent</th>
                <th>Publish</th>
                <th>Images Count</th>
                <th>Views</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($albums as $album)
                <tr>
                    <td><input type="checkbox" data-id="{{$album['id']}}" class="item"></td>
                    <td>{{$album['name']}}</td>
                    <td>{{$album['alias']}}</td>
                    <td>@if($album['type']=='1')
                            None @else {{\App\Models\Category::getCategoryById($album['parent_id'])['name']}} @endif</td>
                    <td>@if($album['publish']==1) Published  @else Unpublished @endif</td>
                    <td>{{$album->images()->count()}}</td>
                    <td>{{$album->visits()->count()}}</td>
                    <td>@if($album['type']=='1') Parent  @else Sub category @endif</td>
                    <td><a href="/{{config('app.admin_route_name')}}/album/edit/{{$album['id']}}"
                           class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <button class="btn btn-danger delete" data-id="{{$album['id']}}"><i
                                    class="glyphicon glyphicon-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $albums->render() !!}
    @endif
@stop