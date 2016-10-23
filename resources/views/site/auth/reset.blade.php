@extends('site.layout')
@section('title')
    Reset password
@stop
@section('content')
    <form role="form" class="form-horizontal form-groups-bordered" method="post"
          enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group @if($errors->has('pass')) has-error @endif">
            <label for="reset_pass" class="col-sm-3 control-label">Password</label>

            <div class="col-sm-5">
                <input type="password" class="form-control" id="reset_pass" name="pass" value="{{old('pass')}}">
                <p class="error">{{$errors->first('pass')}}</p>
            </div>
        </div>
        <div class="form-group @if($errors->has('pass_confirmation')) has-error @endif">
            <label for="reset_pass_confirmation" class="col-sm-3 control-label">Confirm Password</label>

            <div class="col-sm-5">
                <input type="password" class="form-control" id="reset_pass_confirmation" name="pass_confirmation"
                       value="{{old('pass_confirmation')}}">
                <p class="error">{{$errors->first('pass_confirmation')}}</p>
            </div>
            <input type="submit" class="btn btn-default" value="Reset Password">
        </div>
    </form>
@stop