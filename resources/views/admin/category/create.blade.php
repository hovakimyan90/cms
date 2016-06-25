@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{config('app.admin_path')}}/categories">Categories</a>
        </li>
        <li class="active">
            <strong>Create Category</strong>
        </li>
    </ol>
    <h2>Create category</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Create category
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group @if(!empty($errors->first('name'))) has-error @endif">
                            <label for="category_name" class="col-sm-3 control-label">Category name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="category_name"
                                       placeholder="Category name" name="name" value="{{old('name')}}">
                                <p class="error">{{$errors->first('name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if(!empty($errors->first('alias'))) has-error @endif">
                            <label for="category_alias" class="col-sm-3 control-label">Category alias</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="category_alias"
                                       placeholder="Category alias" name="alias" value="{{old('alias')}}">
                                <p class="error">{{$errors->first('alias')}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_meta_keys" class="col-sm-3 control-label">Category meta
                                keywords</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="category_meta_keys"
                                       placeholder="Meta keys" name="meta_keys" value="{{old('meta_keys')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_publish" class="col-sm-3 control-label">Category meta
                                description</label>
                            <div class="col-sm-6">
                                <textarea id="category_meta_desc" name="meta_desc"
                                          placeholder="Meta description"
                                          class="form-control">{{old('meta_desc')}}</textarea>
                            </div>
                        </div>
                        @if(!$categories->isEmpty())
                            <div class="form-group">
                                <label for="category_parent_id" class="col-sm-3 control-label">Select parent
                                    category</label>

                                <div class="col-sm-5">
                                    <select name="parent_id" id="category_parent_id" class="form-control">
                                        <option value="0">Select parent</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}"
                                                    @if(old('parent_id')==$category['id']) selected @endif>
                                                {{$category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="category_publish" class="col-sm-3 control-label">Publish</label>
                            <div class="col-sm-6">
                                <input type="checkbox" id="category_publish" name="publish"
                                       @if(old('publish')) checked @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-default create_category_btn">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop