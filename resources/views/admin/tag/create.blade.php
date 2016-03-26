@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{config('app.admin_path')}}/tags">Tags</a>
        </li>
        <li class="active">
            <strong>Create Tag</strong>
        </li>
    </ol>
    <h2>Create Tag</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Create Tag
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group @if(!empty($errors->first('name'))) has-error @endif">
                            <label for="tag_name" class="col-sm-3 control-label">Tag name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="tag_name"
                                       placeholder="Tag name" name="name">
                                <p class="error">{{$errors->first('name')}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-default">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop