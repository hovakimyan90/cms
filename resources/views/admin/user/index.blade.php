@extends('admin.layout')
@section('content')
    <a href="{{config('app.admin_path')}}/user/create" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create new user
    </a>
    <br/>
    <br/>
    @if(!$users->total())
        <p>No Users</p>
    @else
        <form method="post">
            {!! csrf_field() !!}

            <div class="input-group">
                <input type="text" class="form-control input-lg" name="search" placeholder="Search for something...">

                <div class="input-group-btn">
                    <button type="submit" class="btn btn-lg btn-primary btn-icon">
                        Search
                        <i class="entypo-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <br/>
        <button class="btn btn-danger users_delete_all"><i class="glyphicon glyphicon-trash"></i> Delete</button>
        <a href="{{config('app.admin_path')}}/user/export" class="btn btn-primary export_excel"><i
                    class="entypo-export"></i>
            Export Excel</a>
        <table class="table table-striped users">
            <thead>
            <tr>
                <th><input type="checkbox" class="select_all"></th>
                <th>First name</th>
                <th>Last name</th>
                <th>Profile User</th>
                <th>Phone number</th>
                <th>Position</th>
                <th>Type</th>
                <th>Username</th>
                <th>E-mail</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td><input type="checkbox" data-id="{{$user['id']}}" class="item"></td>
                    <td>{{$user['first_name']}}</td>
                    <td>{{$user['last_name']}}</td>
                    <td>
                        @if(!empty($user['image']))
                            <img src="/uploads/{{$user['image']}}"/>
                        @else None
                        @endif
                    </td>
                    <td>@if(!empty($user['phone'])) {{$user['phone']}} @else None @endif</td>
                    <td>{{$user['position']}}</td>
                    <td>@if($user['role_id']==1) Admin @else User @endif</td>
                    <td>{{$user['username']}}</td>
                    <td>{{$user['email']}}</td>
                    <td><a href="{{config('app.admin_path')}}/user/edit/{{$user['id']}}"
                           class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                        <button class="btn btn-danger delete" data-id="{{$user['id']}}"><i
                                    class="glyphicon glyphicon-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $users->render() !!}
    @endif
@stop