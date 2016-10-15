@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{route('albums')}}">Categories</a>
        </li>
        <li class="active">
            <strong>Create Album</strong>
        </li>
    </ol>
    <h2>Create album</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Create album
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group @if(!empty($errors->first('name'))) has-error @endif">
                            <label for="album_name" class="col-sm-3 control-label">Album name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="album_name"
                                       placeholder="Album name" name="name" value="{{old('name')}}">
                                <p class="error">{{$errors->first('name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if(!empty($errors->first('alias'))) has-error @endif">
                            <label for="album_alias" class="col-sm-3 control-label">Album alias</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="album_alias"
                                       placeholder="Album alias" name="alias" value="{{old('alias')}}">
                                <p class="error">{{$errors->first('alias')}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="album_meta_keys" class="col-sm-3 control-label">Album meta
                                keywords</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="album_meta_keys"
                                       placeholder="Meta keys" name="meta_keys" value="{{old('meta_keys')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="album_publish" class="col-sm-3 control-label">Album meta
                                description</label>
                            <div class="col-sm-6">
                                <textarea id="album_meta_desc" name="meta_desc"
                                          placeholder="Meta description"
                                          class="form-control">{{old('meta_desc')}}</textarea>
                            </div>
                        </div>
                        @if(!$albums->isEmpty())
                            <div class="form-group">
                                <label for="album_parent" class="col-sm-3 control-label">Select parent
                                    album</label>

                                <div class="col-sm-5">
                                    <select name="parent" id="album_parent" class="form-control">
                                        <option value="">Select parent</option>
                                        @foreach($albums as $album)
                                            <option value="{{$album['id']}}"
                                                    @if(old('parent')==$album['id']) selected @endif>
                                                {{$album['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="album_publish" class="col-sm-3 control-label">Publish</label>
                            <div class="col-sm-6">
                                <input type="checkbox" id="album_publish" name="publish"
                                       @if(old('publish')) checked @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-default create_album_btn">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop