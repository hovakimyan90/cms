@extends('site.layout')
@section('title')
    Login
@stop
@section('content')
    <form role="form" class="form-horizontal form-groups-bordered" method="post"
          enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="login_email" class="col-sm-3 control-label">E-mail</label>

            <div class="col-sm-5">
                <input type="text" class="form-control" id="login_email" name="email" value="{{old('email')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="login_pass" class="col-sm-3 control-label">Password</label>

            <div class="col-sm-5">
                <input type="password" class="form-control" id="login_pass" name="pass" value="{{old('pass')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="login_remember" class="col-sm-3 control-label">Remember Me</label>

            <div class="col-sm-5">
                <input type="checkbox" id="login_remember" name="remember" @if(old('remember')) checked @endif>
            </div>
            <input type="submit" class="btn btn-default" value="Login">
        </div>
        @if(session('error'))
            <div class="alert alert-danger" role="alert"><strong>Stop!</strong> Wrong E-mail or Password
            </div>
        @endif
    </form>
@stop