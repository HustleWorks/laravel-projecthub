<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
    <title>Client Name Project Hub</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content="" />

    <!-- http://blog.javierusobiaga.com/stop-using-the-viewport-tag-until-you-know-ho -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="http://fonts.googleapis.com/css?family=Karla:400,700,400italic" rel="stylesheet" type="text/css" />
    <link href="/css/project-hub.css" rel="stylesheet" type="text/css" />
    <link href="/css/modaal.min.css" rel="stylesheet"/>
    <link href="/css/toastr.min.css" rel="stylesheet"/>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

</head>

<body>

<div class="wrap clearfix">


    <div class="page-header-wrap">

        <header class="page-header" role="banner">
            <h1 class="page-header-title">Client Name</h1>
            <h2 class="page-header-subtitle">Project Hub</h2>

                @if(Auth::user())
                    <p><a href="/">Index</a> | <a href="/create">Add Entry</a> | <a href="/logout">Logout</a> </p>
                @else
                    <p><a href="/login">Login</a> to make changes</p>
                @endif

        </header>

    </div><!-- .page-header-wrap -->


    <section role="main" class="main">

        @yield('content')

    </section><!-- .main -->

</div><!-- .wrap -->


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="/js/project-hub.js"></script>
<script src="/js/modaal.min.js"></script>
<script src="/js/toastr.min.js"></script>




@if(Session::has('success'))
    <script>

        var status = "{{Session::get('success')}}";

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        Command: toastr["success"](status);
    </script>

@elseif(Session::has('fail'))
    <script>

        var status = "{{Session::get('fail')}}"

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        Command: toastr["error"](status);

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        Command: toastr["error"](status);

    </script>
@endif


</body>
</html>