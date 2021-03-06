@extends('site.layout')
@section('title')
    Register
@stop
@section('content')
    <form role="form" class="form-horizontal form-groups-bordered" method="post"
          enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group @if($errors->has('first_name')) has-error @endif">
            <label for="register_first_name" class="col-sm-3 control-label">First
                name</label>

            <div class="col-sm-5">
                <input type="text" class="form-control" id="register_first_name"
                       placeholder="First name" name="first_name" value="{{old('first_name')}}">
                <p class="error">{{$errors->first('first_name')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('last_name')) has-error @endif">
            <label for="register_last_name" class="col-sm-3 control-label">Last name</label>

            <div class="col-sm-5">
                <input type="text" class="form-control" id="register_last_name"
                       placeholder="Last name" name="last_name" value="{{old('last_name')}}">
                <p class="error">{{$errors->first('last_name')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('position')) has-error @endif">
            <label for="register_position" class="col-sm-3 control-label">Position</label>

            <div class="col-sm-5">
                <input type="text" class="form-control" id="register_position"
                       placeholder="Position" name="position" value="{{old('position')}}">
                <p class="error">{{$errors->first('position')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('phone')) has-error @endif">
            <label for="register_phone" class="col-sm-3 control-label">Phone number</label>

            <div class="col-sm-5">
                <input type="text" class="form-control" id="register_phone"
                       placeholder="Phone number" name="phone" value="{{old('phone')}}">
                <p class="error">{{$errors->first('phone')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('username')) has-error @endif">
            <label for="register_username" class="col-sm-3 control-label">Username</label>

            <div class="col-sm-5">
                <input type="text" class="form-control" id="register_username"
                       placeholder="Username" name="username" value="{{old('username')}}">
                <p class="error">{{$errors->first('username')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('email')) has-error @endif">
            <label for="register_email" class="col-sm-3 control-label">E-mail</label>

            <div class="col-sm-5">
                <input type="text" class="form-control" id="register_email"
                       placeholder="E-mail" name="email" value="{{old('email')}}">
                <p class="error">{{$errors->first('email')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('pass')) has-error @endif">
            <label for="register_pass" class="col-sm-3 control-label">Password</label>

            <div class="col-sm-5">
                <input type="password" class="form-control" id="register_pass"
                       placeholder="Password" name="pass" value="{{old('pass')}}">
                <p class="error">{{$errors->first('pass')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('pass_confirmation')) has-error @endif">
            <label for="register_pass_confirmation" class="col-sm-3 control-label">Confirm Password</label>

            <div class="col-sm-5">
                <input type="password" class="form-control" id="register_pass_confirmation"
                       placeholder="Confirm Password" name="pass_confirmation" value="{{old('pass_confirmation')}}">
                <p class="error">{{$errors->first('pass_confirmation')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('image')) has-error @endif"
             id="register_profile_image_upload_block">
            <label class="col-sm-3 control-label">Profile picture</label>
            <input type="file" name="image" id="register_image" accept="image/*">
            <p class="error col-sm-6">{{$errors->first('image')}}</p>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <button type="submit" class="btn btn-default create_category_btn">Create</button>
            </div>
        </div>
    </form>
@stop