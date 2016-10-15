<html>
<head>
    <title>@yield('title','GH CMS')</title>
    @if(!empty($favicon))
        <link rel="icon" type="img/ico"
              href="{{asset('storage/uploads/'.$favicon)}}">
    @else
        <link rel="icon" type="img/ico" href="/assets/admin/images/default_favicon.png">
    @endif
    <meta name="description" content="@yield('meta_desc','GH CMS')">
    <meta name="og:description" content="@yield('meta_desc','GH CMS')">
    <meta name="keywords" content="@yield('meta_keys','GH CMS')">
    <meta name="og:image" content="@yield('meta_image',config('app.url').'/assets/site/images/320x160.png')">
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
                @if(!empty($logo))
                    <img src="{{asset('storage/uploads/'.$logo)}}"/>
                @else
                    <img src="/assets/admin/images/default_logo.png"/>
                @endif
            </a></div>
        <ul class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                @if(Auth::user() && Auth::user()->role_id==2)
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

                @foreach($parent_categories as $category)
                    @if(count($category->subCategories)>0)
                        <li class="dropdown">
                            @if($category['content_type']=='1')
                                <a href="/category/{{$category['alias']}}" class="dropdown-toggle"
                                   data-toggle="dropdown" role="button"
                                   aria-haspopup="true"
                                   aria-expanded="false">{{$category['name']}}</a>
                            @endif
                            @if($category['content_type']=='2')
                                <a href="/page/{{$category['alias']}}" class="dropdown-toggle"
                                   data-toggle="dropdown" role="button"
                                   aria-haspopup="true"
                                   aria-expanded="false">{{$category['name']}}</a>
                            @endif
                            @if($category['content_type']=='3')
                                <a href="/album/{{$category['alias']}}" class="dropdown-toggle"
                                   data-toggle="dropdown" role="button"
                                   aria-haspopup="true"
                                   aria-expanded="false">{{$category['name']}}</a>
                            @endif
                            <ul class="dropdown-menu">
                                @foreach($category->subCategories as $subcategory)
                                    <li>
                                        @if($subcategory['content_type']=='1')
                                            <a href="/category/{{$subcategory['alias']}}">{{$subcategory['name']}}</a>
                                        @endif
                                        @if($subcategory['content_type']=='2')
                                            <a href="/page/{{$subcategory['alias']}}">{{$subcategory['name']}}</a>
                                        @endif
                                        @if($subcategory['content_type']=='3')
                                            <a href="/album/{{$subcategory['alias']}}">{{$subcategory['name']}}</a>
                                        @endif

                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            @if($category['content_type']=='1')
                                <a href="/category/{{$category['alias']}}">{{$category['name']}}</a>
                            @endif
                            @if($category['content_type']=='2')
                                <a href="/page/{{$category['alias']}}">{{$category['name']}}</a>
                            @endif
                            @if($category['content_type']=='3')
                                <a href="/album/{{$category['alias']}}">{{$category['name']}}</a>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
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