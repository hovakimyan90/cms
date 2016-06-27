@extends('site.layout')
@section('content')
    <form role="form" class="form-horizontal form-groups-bordered" method="post"
          enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="form-group @if($errors->has('email')) has-error @endif">
            <label for="forget_email" class="col-sm-3 control-label">E-mail</label>

            <div class="col-sm-5">
                <input type="text" class="form-control" id="forget_email"
                       placeholder="E-mail" name="email" value="{{old('email')}}">
                <p class="error">{{$errors->first('email')}}</p>
            </div>
            <input type="submit" class="btn btn-default" value="Reset Password">
        </div>
    </form>
@stop