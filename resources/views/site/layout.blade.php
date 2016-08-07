<html>
<head>
    <title>{{$title}}</title>
    @if(!empty(\App\Models\Settings::getSettings()['favicon']))
        <link rel="icon" type="img/ico" href="/uploads/<?= \App\Models\Settings::getSettings()['favicon'] ?>">
    @else
        <link rel="icon" type="img/ico" href="/assets/admin/images/default_favicon.png">
    @endif
    @if(isset($category) && $category->meta_desc)
        <meta name="description" content="{{$category->meta_desc}}">
    @else
        <meta name="description" content="GH CMS">
    @endif
    @if(isset($category) && $category->meta_keys)
        <meta name="keywords" content="{{$category->meta_keys}}">
    @else
        <meta name="keywords" content="GH CMS">
    @endif
    @if(isset($meta_desc) && !empty($meta_desc))
        <meta name="description" content="{{$meta_desc}}">
        <meta name="og:description" content="{{$meta_desc}}">
    @else
        <meta name="description" content="CMS">
        <meta name="og:description" content="CMS">
    @endif
    @if(isset($meta_keys) && !empty($meta_keys))
        <meta name="keywords" content="{{$meta_keys}}">
    @else
        <meta name="keywords" content="CMS">
    @endif
    @if(isset($meta_image) && !empty($meta_image))
        <meta name="og:image" content="{{config('app.url')}}/uploads/{{$meta_image}}">
    @else
        <meta name="og:image" content="{{config('app.url')}}/assets/site/images/320x160.png">
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
                @if(Auth::user())
                    @if(Auth::user()->notification==1)
                        <li class="dropdown notifications">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false">Notifications (<span class="count"></span>)</a>
                            <ul class="dropdown-menu notifications_list">

                            </ul>
                        </li>
                    @endif
                    <li><a href="/logout">Log out</a></li>
                @endif
                @foreach(App\Models\Category::getCategoriesByPublish(1,0) as $category)
                    @if(!\App\Models\Category::getSubcategoriesByParentId($category['id'])->isEmpty())
                        <li class="dropdown">
                            <a href="/category/{{$category['alias']}}" class="dropdown-toggle"
                               data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false">{{$category['name']}}</a>
                            <ul class="dropdown-menu">
                                @foreach(\App\Models\Category::getSubcategoriesByParentId($category['id']) as $subcategory)
                                    <li><a href="/category/{{$subcategory['alias']}}">{{$subcategory['name']}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li><a href="/category/{{$category['alias']}}">{{$category['name']}}</a></li>
                    @endif
                @endforeach
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
<script src="/assets/site/js/functions.js"></script>
<script src="/assets/site/js/custom.js"></script>
</body>
</html>