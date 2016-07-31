@foreach($notifications as $notification)
    <li class="unread notification-success">
        <a href="#">
            <i class="entypo-user-add pull-right"></i>

                <span class="line">
                    @if($notification->type==1)
                        <strong>Welcome our admin panel</strong>
                    @endif
                    @if($notification->type==2)
                        <strong>New user registered</strong>
                    @endif
                    @if($notification->type==3)
                        <strong>{{$notification->sender->email}}
                            write a new post and want that you approve post</strong>
                    @endif
                </span>

                <span class="line small">
                    {{$notification->created_at}}
                </span>
        </a>
    </li>
@endforeach