@foreach($notifications as $notification)
    <li>
        @if($notification->type==4)
            <span>Welcome to our site</span>
        @endif
        @if($notification->type==5)
            <span>Admin approved your post</span>
        @endif
        @if($notification->type==6)
            <span>Admin disapproved your post</span>
        @endif
        <span>
                    {{$notification->created_at}}
                </span>
    </li>
    <li role="separator" class="divider"></li>
@endforeach