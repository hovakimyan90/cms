<html>
<head>
    <title>{{$title}}</title>
    @if(!empty(\App\Models\Settings::getSettings()['favicon']))
        <link rel="icon" type="img/ico" href="/uploads/<?= \App\Models\Settings::getSettings()['favicon'] ?>">
    @else
        <link rel="icon" type="img/ico" href="/assets/admin/images/default_favicon.png">
    @endif

    <link rel="stylesheet" href="/assets/site/css/chosen.min.css">
    <link rel="stylesheet" href="/assets/site/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/site/css/custom.css">
    {{--<link rel="stylesheet" href="/assets/site/css/neon-forms.css">--}}

    <script src="/assets/site/js/jquery-1.11.0.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<audio style="display: none;" id="notification_sound">
    <source src="/assets/sounds/notification_sound.mp3" type="audio/mpeg">
</audio>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-9" aria-expanded="false"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="#">
                @if(!empty(\App\Models\Settings::getSettings()['logo']))
                    <img src="/uploads/<?= \App\Models\Settings::getSettings()['logo'] ?>"/>
                @else
                    <img src="/assets/admin/images/default_logo.png"/>
                @endif
            </a></div>
        <ul class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
                <li class="dropdown notifications">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">Notifications (<span class="count"></span>)</a>
                    <ul class="dropdown-menu notifications_list">

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<script src="/assets/site/js/bootstrap.min.js"></script>
<script src="/assets/admin/js/tinymce/tinymce.min.js"></script>
<script src="/assets/admin/js/tinymce/plugins/compat3x/plugin.min.js"></script>
<script src="/assets/site/js/chosen.jquery.min.js"></script>
<script src="/assets/site/js/fileinput.js"></script>
<script src="/assets/site/js/bootbox/js/bootbox.min.js"></script>
<script src="/assets/site/js/init.js"></script>
<script src="/assets/site/js/functions.js"></script>
<script src="/assets/site/js/custom.js"></script>
</body>
</html>