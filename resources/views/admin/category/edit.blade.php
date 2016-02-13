@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="index.html"><i class="fa-home"></i>Home</a>
        </li>
        <li>
            <a href="forms-main.html">Forms</a>
        </li>
        <li class="active">
            <strong>Basic Elements</strong>
        </li>
    </ol>
    <h2>Edit category</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Default Form Inputs
                    </div>
                    <div class="panel-options">
                        <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i
                                    class="entypo-cog"></i></a>
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group @if(!empty($errors->first('name'))) has-error @endif">
                            <label for="category_name" class="col-sm-3 control-label">Category name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="category_name"
                                       placeholder="Category name" name="name" value="{{$category['name']}}">
                                <p class="error">{{$errors->first('name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if(!empty($errors->first('alias'))) has-error @endif">
                            <label for="category_alias" class="col-sm-3 control-label">Category alias</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="category_alias"
                                       placeholder="Category alias" name="alias" value="{{$category['alias']}}">
                                <p class="error">{{$errors->first('alias')}}</p>
                            </div>
                        </div>
                        @if(!empty($categories))
                            <div class="form-group @if(!empty($errors->first('alias'))) has-error @endif">
                                <label for="parent" class="col-sm-3 control-label">Select parent
                                    category</label>

                                <div class="col-sm-5">
                                    <select name="parent" id="parent">
                                        <option>Select parent</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat['id']}}"
                                                    @if($cat['id']==$category['parent']) selected @endif>{{$cat['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="category_publish" class="col-sm-3 control-label">Show in menu</label>
                            <div class="col-sm-6">
                                <input type="checkbox" id="category_publish" name="publish"
                                       @if($category['id']==1) checked @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-default edit_category_btn">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop