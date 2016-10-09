@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{route('pages')}}">Pages</a>
        </li>
        <li class="active">
            <strong>Create Page</strong>
        </li>
    </ol>
    <h2>Create page</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Create page
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group @if(!empty($errors->first('name'))) has-error @endif">
                            <label for="page_name" class="col-sm-3 control-label">Page name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="page_name"
                                       placeholder="Page name" name="name" value="{{old('name')}}">
                                <p class="error">{{$errors->first('name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if(!empty($errors->first('alias'))) has-error @endif">
                            <label for="page_alias" class="col-sm-3 control-label">Page alias</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="page_alias"
                                       placeholder="Page alias" name="alias" value="{{old('alias')}}">
                                <p class="error">{{$errors->first('alias')}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="page_meta_keys" class="col-sm-3 control-label">Page meta
                                keywords</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="page_meta_keys"
                                       placeholder="Meta keys" name="meta_keys" value="{{old('meta_keys')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="page_publish" class="col-sm-3 control-label">Page meta
                                description</label>
                            <div class="col-sm-6">
                                <textarea id="page_meta_desc" name="meta_desc"
                                          placeholder="Meta description"
                                          class="form-control">{{old('meta_desc')}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 @if(!empty($errors->first('content'))) has-error @endif">
                <textarea class="form-control wysihtml5" rows="18" data-stylesheet-url="assets/css/wysihtml5-color.css"
                          name="content" id="page_content">{{old('content')}}</textarea>
                                <p class="error">{{$errors->first('content')}}</p>
                            </div>
                        </div>
                        @if(!$pages->isEmpty())
                            <div class="form-group">
                                <label for="page_parent" class="col-sm-3 control-label">Select parent
                                    page</label>

                                <div class="col-sm-5">
                                    <select name="parent" id="page_parent" class="form-control">
                                        <option value="">Select parent</option>
                                        @foreach($pages as $page)
                                            <option value="{{$page['id']}}"
                                                    @if(old('parent')==$page['id']) selected @endif>
                                                {{$page['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="page_publish" class="col-sm-3 control-label">Publish</label>
                            <div class="col-sm-6">
                                <input type="checkbox" id="page_publish" name="publish"
                                       @if(old('publish')) checked @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-default create_page_btn">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop