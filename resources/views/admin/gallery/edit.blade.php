@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{route('approved_users')}}">Gallery</a>
        </li>
        <li class="active">
            <strong>Create Gallery Image</strong>
        </li>
    </ol>
    <h2>Create Image</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Create Image
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="gallery_title" class="col-sm-3 control-label">Title</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="gallery_title"
                                       placeholder="Title" name="title" value="{{$gallery['title']}}">
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('link')) has-error @endif">
                            <label for="gallery_link" class="col-sm-3 control-label">Link</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="gallery_link"
                                       placeholder="Link" name="link" value="@if(empty(old()) && !isset(old()['link'])){{$gallery->link}}@else{{old('link')}}@endif">
                                <p class="error">{{$errors->first('link')}}</p>
                            </div>
                        </div>
                        @if(!$albums->isEmpty())
                            <div class="form-group">
                                <label for="page_parent" class="col-sm-3 control-label">Select parent
                                    page</label>

                                <div class="col-sm-5">
                                    <select name="album" id="gallery_parent" class="form-control">
                                        <option value="">Select parent</option>
                                        @foreach($albums as $album)
                                            <option value="{{$album['id']}}"
                                                    @if($gallery['album_id']==$album['id']) selected @endif>
                                                {{$album['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group @if($errors->has('image')) has-error @endif"
                             id="gallery_profile_image_upload_block">
                            <label class="col-sm-3 control-label">Profile picture</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px;"
                                     data-trigger="fileinput">
                                    @if(empty($gallery->image))
                                        <img src="/assets/admin/images/320x160.png">
                                    @else
                                        <img src="{{asset('storage/uploads/'.$gallery['image'])}}">
                                    @endif
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 320px; max-height: 160px"></div>
                                <div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="image" id="gallery_image" accept="image/*">
									</span>
                                    <a href="#" class="btn btn-orange fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                            <p class="error col-sm-6">{{$errors->first('image')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="page_publish" class="col-sm-3 control-label">Publish</label>
                            <div class="col-sm-6">
                                <input type="checkbox" id="page_publish" name="publish"
                                       @if($gallery['publish']=='1') checked @endif>
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