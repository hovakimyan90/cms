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
                                       placeholder="Category name" name="name">
                                <p class="error">{{$errors->first('name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if(!empty($errors->first('alias'))) has-error @endif">
                            <label for="category_alias" class="col-sm-3 control-label">Category alias</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="category_alias"
                                       placeholder="Category alias" name="alias">
                                <p class="error">{{$errors->first('alias')}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_meta_keys" class="col-sm-3 control-label">Category meta
                                keywords</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="category_meta_keys"
                                       placeholder="Meta keys" name="meta_keys">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_publish" class="col-sm-3 control-label">Category meta
                                description</label>
                            <div class="col-sm-6">
                                <textarea id="category_meta_desc" name="meta_desc"
                                          placeholder="Meta description" class="form-control"></textarea>
                            </div>
                        </div>
                        @if(!empty($categories))
                            <div class="form-group">
                                <label for="category_alias" class="col-sm-3 control-label">Select parent
                                    category</label>

                                <div class="col-sm-5">
                                    <select name="parent">
                                        <option value="">Select parent</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}">{{$category['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="category_publish" class="col-sm-3 control-label">Show in menu</label>
                            <div class="col-sm-6">
                                <input type="checkbox" id="category_publish" name="publish">
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