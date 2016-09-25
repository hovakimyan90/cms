@extends('admin.layout')
@section('content')
    <a href="/{{config('app.admin_route_name')}}/page/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create new page
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
    @if(!$pages->total())
        <p>No Pages</p>
    @else
        {!! csrf_field() !!}
        <button class="btn btn-danger pages_delete_all"><i class="glyphicon glyphicon-trash"></i> Delete</button>
        <a href="/{{config('app.admin_route_name')}}/page/export" class="btn btn-primary export_excel"><i
                    class="entypo-export"></i>
            Export Excel</a>
        <table class="table table-striped pages">
            <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>Name</th>
                <th>Alias</th>
                <th>Parent</th>
                <th>Publish</th>
                <th>Views</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td><input type="checkbox" data-id="{{$page['id']}}" class="item"></td>
                    <td>{{$page['name']}}</td>
                    <td>{{$page['alias']}}</td>
                    <td>@if($page['type']=='parent')
                            None @else {{\App\Models\Category::getCategoryById($page['parent_id'])['name']}} @endif</td>
                    <td>@if($page['publish']==1) Published  @else Unpublished @endif</td>
                    <td>{{$page->visits()->count()}}</td>
                    <td>@if($page['type']=='1') Parent  @else Sub page @endif</td>
                    <td><a href="/{{config('app.admin_route_name')}}/page/edit/{{$page['id']}}"
                           class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <button class="btn btn-danger delete" data-id="{{$page['id']}}"><i
                                    class="glyphicon glyphicon-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $pages->render() !!}
    @endif
@stop