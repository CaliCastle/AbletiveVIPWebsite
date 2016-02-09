<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('app.site.description') }}">
    <meta name="keywords" content="{{ config('app.site.keywords') }}">
    <meta name="author" content="{{ config('app.site.author') }}">

    <link rel="icon" href="{{ url('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ url('favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ url('favicon.png') }}">

    <title>@yield('title'){{ isset($title) ? $title : "" }} :: {{ config('app.site.title') }}
        - {{ config('app.site.title_extra') }}</title>

    <!-- Fonts -->
    <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.useso.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">
    <script src="{{ url('js/modernizr.custom.js') }}"></script>
    <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    @yield('styles')
    @yield('header-scripts')

    @unless(Auth::guest())
        <script>
            var AVATAR_URL = "{{ Auth::user()->avatar ? Auth::user()->avatar : url('/images/default-avatar.png') }}";
        </script>
    @endunless

</head>
<body id="app-layout">

    @include('layouts.partials.navigation-bar')

    @yield('content')

    @include('layouts.partials.footer')

    <!-- JavaScripts -->
    <script src="{{ elixir('js/all.js') }}"></script>

    <script>
        function logoutDidClick() {
            swal({
                title: "确定要注销吗?",
                text: "注销后无法访问该页面, 页面将跳转到登录页面!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "取消",
                confirmButtonText: "注销吧!",
                closeOnConfirm: false
            }, function(){
                window.location.href = "{{ url('/logout') }}";
            });
        }

        function showStatusMessage(message) {
            // create the notification
            var notification = new NotificationFx({
                message : '<div class="ns-thumb"><img src="' + AVATAR_URL + '"/></div><div class="ns-content"><p>' +
                message + '</p></div>',
                layout : 'other',
                ttl: 4000,
                effect : 'thumbslider',
                type : 'notice',
                onClose : function() {

                }
            });

            // show the notification
            notification.show();
        }

        @if(session('status'))
            showStatusMessage("{!! session('status') !!}");
        @endif
    </script>
    @yield('footer-scripts')

</body>
</html>
