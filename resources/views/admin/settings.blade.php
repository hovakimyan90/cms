@extends('admin.layout')
@section('content')
    <h1 class="margin-bottom">Settings</h1>
    <ol class="breadcrumb 2">
        <li>
            <a href="index.html"><i class="fa-home"></i>Home</a>
        </li>
        <li>

            <a href="extra-icons.html">Extra</a>
        </li>
        <li class="active">

            <strong>Settings</strong>
        </li>
    </ol>

    <br/>

    <form role="form" method="post" class="form-horizontal form-groups-bordered site_settings_form" action=""
          enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-primary" data-collapsed="0">

                    <div class="panel-heading">
                        <div class="panel-title">
                            General Settings
                        </div>

                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="form-group @if($errors->first('title')) has-error @endif">
                            <label for="field-1" class="col-sm-3 control-label">Site title</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="site_settings_title"
                                       value="{{$settings['title']}}" name="title">
                                <p class="error">{{$errors->first('title')}}</p>
                            </div>
                        </div>

                        <div class="form-group @if($errors->first('desc')) has-error @endif">
                            <label for="field-2" class="col-sm-3 control-label">Meta description</label>

                            <div class="col-sm-5">
                                <textarea name="desc" class="form-control"
                                          id="site_settings_meta_desc">{{$settings['desc']}}</textarea>
                                <p class="error">{{$errors->first('desc')}}</p>
                                {{--<input type="text" class="form-control" id="field-2" value="{{$settings['desc']}}">--}}
                                {{--<span class="description">Few words that will describe your site.</span>--}}
                            </div>
                        </div>

                        <div class="form-group @if($errors->first('keys')) has-error @endif">
                            <label for="field-2" class="col-sm-3 control-label">Meta keywords</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="site_settings_meta_keywords"
                                       value="{{$settings['keys']}}" name="keys">
                                <p class="error">{{$errors->first('keys')}}</p>
                                {{--<span class="description">Few words that will describe your site.</span>--}}
                            </div>
                        </div>

                        <div class="form-group @if($errors->first('keys')) has-error @endif">
                            <label for="field-3" class="col-sm-3 control-label">Site URL</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="url" id="site_settings_url"
                                       value="{{$settings['url']}}">
                                <p class="error">{{$errors->first('url')}}</p>
                            </div>
                        </div>

                        <div class="form-group @if($errors->first('keys')) has-error @endif">
                            <label for="field-4" class="col-sm-3 control-label">Email address</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email" id="site_settings_email"
                                       value="{{$settings['email']}}">
                                <p class="error">{{$errors->first('email')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('logo')) has-error @endif"
                             id="site_settings_logo_upload_block">
                            <label class="col-sm-3 control-label">Image</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px;"
                                     data-trigger="fileinput">
                                    @if(empty($settings['logo']))
                                        <img src="/public/assets/admin/images/default_logo.png">
                                    @else
                                        <img src="/public/uploads/{{$settings['logo']}}">
                                    @endif
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 320px; max-height: 160px"></div>
                                <div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="logo" id="site_settings_logo" accept="image/*">
									</span>
                                    <a href="#" class="btn btn-orange fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                            <p class="error col-sm-6">{{$errors->first('logo')}}</p>
                        </div>
                        <div class="form-group @if($errors->has('favicon')) has-error @endif"
                             id="site_settings_favicon_upload_block">
                            <label class="col-sm-3 control-label">Favicon</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px;"
                                     data-trigger="fileinput">
                                    @if(empty($settings['favicon']))
                                        <img src="/public/assets/admin/images/default_favicon.png">
                                    @else
                                        <img src="/public/uploads/{{$settings['favicon']}}">
                                    @endif
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 320px; max-height: 160px"></div>
                                <div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="favicon" id="site_settings_favicon" accept="image/*">
									</span>
                                    <a href="#" class="btn btn-orange fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                            <p class="error col-sm-6">{{$errors->first('favicon')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="site_settings_on_site" class="col-sm-3 control-label">On Site</label>
                            <div class="col-sm-6">
                                <input type="radio" id="site_settings_on_site" name="site" value="1"
                                       @if($settings['site']==1) checked @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="site_settings_off_site" class="col-sm-3 control-label">Off Site</label>
                            <div class="col-sm-6">
                                <input type="radio" id="site_settings_off_site" name="site" value="0"
                                       @if($settings['site']==0) checked @endif>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <div class="form-group default-padding">
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>

    </form>
@endsection