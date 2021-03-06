@extends('admin.layout')
@section('content')
    <a href="/{{config('app.admin_route_name')}}/category/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create new category
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
    @if(!$categories->total())
        <p>No Categories</p>
    @else
        {!! csrf_field() !!}
        <button class="btn btn-danger categories_delete_all"><i class="glyphicon glyphicon-trash"></i> Delete</button>
        <a href="/{{config('app.admin_route_name')}}/category/export" class="btn btn-primary export_excel"><i
                    class="entypo-export"></i>
            Export Excel</a>
        <table class="table table-striped categories">
            <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>Name</th>
                <th>Alias</th>
                <th>Parent</th>
                <th>Publish</th>
                <th>Posts Count</th>
                <th>Views</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td><input type="checkbox" data-id="{{$category['id']}}" class="item"></td>
                    <td>{{$category['name']}}</td>
                    <td>{{$category['alias']}}</td>
                    <td>@if($category['type']=='1')
                            None @else {{\App\Models\Category::getCategoryById($category['parent_id'])['name']}} @endif</td>
                    <td>@if($category['publish']==1) Published  @else Unpublished @endif</td>
                    <td>{{$category->posts()->count()}}</td>
                    <td>{{$category->visits()->count()}}</td>
                    <td>@if($category['type']=='1') Parent  @else Sub category @endif</td>
                    <td><a href="/{{config('app.admin_route_name')}}/category/edit/{{$category['id']}}"
                           class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <button class="btn btn-danger delete" data-id="{{$category['id']}}"><i
                                    class="glyphicon glyphicon-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $categories->render() !!}
    @endif
@stop