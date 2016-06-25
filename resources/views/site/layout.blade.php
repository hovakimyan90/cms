<html>
<head>
    <title>{{$title}}</title>
    <link rel="stylesheet" href="/assets/site/css/bootstrap.min.css" type="text/css">
    @if(!empty(\App\Models\Settings::getSettings()['favicon']))
        <link rel="icon" type="img/ico" href="/uploads/<?= \App\Models\Settings::getSettings()['favicon'] ?>">
    @else
        <link rel="icon" type="img/ico" href="/assets/admin/images/default_favicon.png">
    @endif
    <script src="/assets/site/js/jquery-1.11.0.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
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
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<script src="/assets/site/js/bootstrap.min.js"></script>
</body>
</html>