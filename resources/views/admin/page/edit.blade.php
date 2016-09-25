@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="/{{config('app.admin_route_name')}}/pages">Pages</a>
        </li>
        <li class="active">
            <strong>Edit Page</strong>
        </li>
    </ol>
    <h2>Edit page</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Edit page
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group @if(!empty($errors->first('name'))) has-error @endif">
                            <label for="page_name" class="col-sm-3 control-label">Page name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="page_name"
                                       placeholder="Page name" name="name" value="{{$page->name}}">
                                <p class="error">{{$errors->first('name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if(!empty($errors->first('alias'))) has-error @endif">
                            <label for="page_alias" class="col-sm-3 control-label">Page alias</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="page_alias"
                                       placeholder="Page alias" name="alias" value="{{$page->alias}}">
                                <p class="error">{{$errors->first('alias')}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="page_meta_keys" class="col-sm-3 control-label">Page meta
                                keywords</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="page_meta_keys"
                                       placeholder="Page meta keywords" name="meta_keys"
                                       value="{{$page->meta_keys}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="page_meta_keys" class="col-sm-3 control-label">Page meta
                                description</label>

                            <div class="col-sm-5">
                                 <textarea id="page_meta_desc" name="meta_desc"
                                           placeholder="Meta description"
                                           class="form-control">{{$page->meta_desc}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 @if(!empty($errors->first('content'))) has-error @endif">
                <textarea class="form-control wysihtml5" rows="18" data-stylesheet-url="assets/css/wysihtml5-color.css"
                          name="content" id="page_content">{{$page->content->content}}</textarea>
                                <p class="error">{{$errors->first('content')}}</p>
                            </div>
                        </div>
                        @if(!$pages->isEmpty())
                            <div class="form-group">
                                <label for="parent" class="col-sm-3 control-label">Select parent page</label>

                                <div class="col-sm-5">
                                    <select name="parent" id="parent" class="form-control">
                                        <option value="">Select parent</option>
                                        @foreach($pages as $cat)
                                            <option value="{{$cat['id']}}"
                                                    @if($cat['id']==$page->parent_id) selected @endif>{{$cat['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="page_publish" class="col-sm-3 control-label">Publish</label>
                            <div class="col-sm-6">
                                <input type="checkbox" id="page_publish" name="publish"
                                       @if($page->publish==1) checked @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-default edit_page_btn">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop