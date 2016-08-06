@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="/{{config('app.admin_route_name')}}/categories">Users</a>
        </li>
        <li class="active">
            <strong>Create User</strong>
        </li>
    </ol>
    <h2>Create user</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Edit profile
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group @if($errors->has('first_name')) has-error @endif">
                            <label for="register_first_name" class="col-sm-3 control-label">First
                                name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="register_first_name"
                                       placeholder="First name" name="first_name" value="{{$user->first_name}}">
                                <p class="error">{{$errors->first('first_name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('last_name')) has-error @endif">
                            <label for="register_last_name" class="col-sm-3 control-label">Last name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="register_last_name"
                                       placeholder="Last name" name="last_name" value="{{$user->last_name}}">
                                <p class="error">{{$errors->first('last_name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('email')) has-error @endif">
                            <label for="register_email" class="col-sm-3 control-label">E-mail</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="register_email"
                                       placeholder="E-mail" name="email" value="{{$user->email}}">
                                <p class="error">{{$errors->first('email')}}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="register_notification" class="col-sm-3 control-label">Notifications</label>

                            <div class="col-sm-5">
                                <input type="checkbox" id="register_notification"
                                       name="notification" @if($user->notification==1) checked @endif>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('pass')) has-error @endif">
                            <label for="register_pass" class="col-sm-3 control-label">Password</label>

                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="register_pass"
                                       placeholder="Password" name="pass">
                                <p class="error">{{$errors->first('pass')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('pass_confirmation')) has-error @endif">
                            <label for="register_pass_confirmation" class="col-sm-3 control-label">Confirm
                                Password</label>

                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="register_pass_confirmation"
                                       placeholder="Confirm Password" name="pass_confirmation">
                                <p class="error">{{$errors->first('pass_confirmation')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('image')) has-error @endif"
                             id="register_profile_image_upload_block">
                            <label class="col-sm-3 control-label">Profile picture</label>
                            <div class="col-sm-5">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px;"
                                         data-trigger="fileinput">
                                        @if(!empty($user->image))
                                            <img src="/uploads/{{$user->image}}">
                                        @else
                                            <img src="/assets/site/images/320x160.png">
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 320px; max-height: 160px"></div>
                                    <div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="image" id="post_image" accept="image/*">
									</span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                                <p class="error">{{$errors->first('image')}}</p>
                            </div>
                            {{--<input type="file" name="image" id="register_image" accept="image/*">--}}
                            {{--<p class="error col-sm-6">{{$errors->first('image')}}</p>--}}
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