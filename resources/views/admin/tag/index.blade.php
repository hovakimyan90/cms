@extends('admin.layout')
@section('content')
    <a href="/{{config('app.admin_route_name')}}/tag/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create new tag
    </a>
    <br/>
    <br/>
    @if(!$tags->total())
        <p>No Tags</p>
    @else
        <form method="post">
            {!! csrf_field() !!}

            <div class="input-group">
                <input type="text" class="form-control input-lg" name="search" placeholder="Search for something...">

                <div class="input-group-btn">
                    <button type="submit" class="btn btn-lg btn-primary btn-icon">
                        Search
                        <i class="entypo-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <br/>
        <button class="btn btn-danger tags_delete_all"><i class="glyphicon glyphicon-trash"></i> Delete</button>
        <a href="/{{config('app.admin_route_name')}}/tag/export" class="btn btn-primary export_excel"><i
                    class="entypo-export"></i>
            Export Excel</a>
        <table class="table table-striped tags">
            <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td><input type="checkbox" data-id="{{$tag['id']}}"></td>
                    <td>{{$tag['name']}}</td>
                    <td><a href="/{{config('app.admin_route_name')}}/tag/edit/{{$tag['id']}}"
                           class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <button class="btn btn-danger delete" data-id="{{$tag['id']}}"><i
                                    class="glyphicon glyphicon-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $tags->render() !!}
    @endif
@stop