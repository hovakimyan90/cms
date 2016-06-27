@extends('admin.layout')
@section('content')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{config('app.admin_path')}}/users">Users</a>
        </li>
        <li class="active">
            <strong>Create User</strong>
        </li>
    </ol>
    <h2>Create User</h2>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Create user
                    </div>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-groups-bordered" method="post"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group @if($errors->has('first_name')) has-error @endif">
                            <label for="user_first_name" class="col-sm-3 control-label">First
                                name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="user_first_name"
                                       placeholder="First name" name="first_name" value="{{old('first_name')}}">
                                <p class="error">{{$errors->first('first_name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('last_name')) has-error @endif">
                            <label for="user_last_name" class="col-sm-3 control-label">Last name</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="user_last_name"
                                       placeholder="Last name" name="last_name" value="{{old('last_name')}}">
                                <p class="error">{{$errors->first('last_name')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('position')) has-error @endif">
                            <label for="user_position" class="col-sm-3 control-label">Position</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="user_position"
                                       placeholder="Position" name="position" value="{{old('position')}}">
                                <p class="error">{{$errors->first('position')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('type')) has-error @endif">
                            <label for="user_type" class="col-sm-3 control-label">Role</label>

                            <div class="col-sm-5">
                                <select name="type" class="form-control">
                                    <option value="">Select User role</option>
                                    <option value="1" @if(old('type')=='1') selected @endif>Admin</option>
                                    <option value="2" @if(old('type')=='2') selected @endif>User</option>
                                </select>
                                <p class="error">{{$errors->first('type')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('phone')) has-error @endif">
                            <label for="user_phone" class="col-sm-3 control-label">Phone number</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="user_phone"
                                       placeholder="Phone number" name="phone" value="{{old('phone')}}">
                                <p class="error">{{$errors->first('phone')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('username')) has-error @endif">
                            <label for="user_username" class="col-sm-3 control-label">Username</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="user_username"
                                       placeholder="Username" name="username" value="{{old('username')}}">
                                <p class="error">{{$errors->first('username')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('email')) has-error @endif">
                            <label for="user_email" class="col-sm-3 control-label">E-mail</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="user_email"
                                       placeholder="E-mail" name="email" value="{{old('email')}}">
                                <p class="error">{{$errors->first('email')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('pass')) has-error @endif">
                            <label for="user_pass" class="col-sm-3 control-label">Password</label>

                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="user_pass"
                                       placeholder="Password" name="pass">
                                <p class="error">{{$errors->first('pass')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('pass')) has-error @endif">
                            <label for="user_pass_confirmation" class="col-sm-3 control-label">Confirm Password</label>

                            <div class="col-sm-5">
                                <input type="password" class="form-control" id="user_pass_confirmation"
                                       placeholder="Confirm Password" name="pass_confirmation">
                                <p class="error">{{$errors->first('pass_confirmation')}}</p>
                            </div>
                        </div>
                        <div class="form-group @if($errors->has('image')) has-error @endif"
                             id="user_profile_image_upload_block">
                            <label class="col-sm-3 control-label">Profile picture</label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px;"
                                     data-trigger="fileinput">
                                    <img src="/assets/admin/images/320x160.png">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 320px; max-height: 160px"></div>
                                <div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="image" id="user_image" accept="image/*">
									</span>
                                    <a href="#" class="btn btn-orange fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                            <p class="error col-sm-6">{{$errors->first('image')}}</p>
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