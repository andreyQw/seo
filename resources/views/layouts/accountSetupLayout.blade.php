<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NO-BS') }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/layout_dashboard_style.css')}}">
    <link rel="stylesheet" href="{{asset('css/jscroll.css')}}">

    <link rel="stylesheet" href="{{asset('css/switch_btn.css')}}">

    <link rel="stylesheet" href="{{ asset('css/setting_page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/link_anchor_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bio_manager_style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/acss/product_list.css') }}">

    <style>
        @font-face {
            font-family: "HelveticaNeue";
            src: url("{{ asset('fonts/HelveticaNeue.ttf') }}");
            font-style: normal;
            font-weight: normal;
        }
        @font-face {
            font-family: "Helvetica Neue Medium";
            src: url("{{ asset('fonts/HelveticaNeue-Medium.ttf') }}");
        }
    </style>

</head>
<body>

<div class="wrapper">

    <nav class="navbar navbar-fixed-top nobs_nav" role="navigation">

        <div class="collapse navbar-collapse nav_bar">
            {{--<p class="navbar-text name_panel">@yield('name')</p>--}}
            <span class="name_block_set" style="padding: 15px">Account Setup</span>
            <div class="nav navbar-nav navbar-right nav_user_cont">
                <span class="notification_icon"><div id="circ_not"></div></span>
                <div class="photo_user">
                    <img src="{{ asset('storage/photo_users/' . Auth::user()->photo) }}" alt="">
                    <div id="circ_online"></div>
                </div>
                <div class="name_user_nav">
                    <span style="line-height: 12px;">
                        {{ ucfirst(Auth::user()->first_name) . ' ' . ucfirst(Auth::user()->last_name) }}
                    </span>
                    <span>
                        <a href="{{ route('logout') }}" onclick="" style="text-decoration: none">
                        <span style="display: inline-block; color: black; font-size: 12px; text-align: left;">Signout</span>
                        <span style="display: inline-block; color: black; text-align: left;" class="caret"></span>
                        </a>
                    </span>
                </div>
            </div>


            {{--@yield('button_navbar')--}}


        </div>

    </nav>

    <div class="container-fluid" style="padding-left: 0; background-color: #3b4685; margin-left: 0 !important; margin-right: 0 !important;">
        <div class="left_sidebar">

            <div class="sidebar-header"><img src="{{ asset('img/main_logo_dashboard.png') }}" alt=""></div>
            <ul class="nav nav-sidebar">
                {{--<li><span></span><a href="">Dashboard</a></li>--}}
                {{--<li><span></span><a href="">Websites</a></li>--}}
                {{--<li><span></span><a href="">Bio Manager</a></li>--}}
                {{--<li><span></span><a href="">Link & Anchor Manager</a></li>--}}
                {{--@role('client')--}}
                {{--<li id="icon_sidebar_5"><span></span><a href="">Invoices</a></li>--}}
                {{--@else--}}

                {{--@endrole--}}

                {{--<ul class="nav footer_bar">--}}
                    {{--<li id="footer_sidebar_1">--}}
                        {{--<span></span>--}}
                        {{--                            <a href="{{ route('settings') }}">Setting</a>--}}
                    {{--</li>--}}
                    {{--<li id="footer_sidebar_2">--}}
                        {{--<span></span>--}}
                        {{--                            <a href="{{ route('logout') }}" onclick="">Logout</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            </ul>

        </div>
    </div>

    <div class="container-fluid" style="padding-left: 0; margin-left: 240px; margin-right: 0 !important; width: 100% !important;">
        <div class="col-sm-12 col-md-12 main">

            @yield('content')

        </div>
    </div>
</div>

{{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
    {{--{{ csrf_field() }}--}}
{{--</form>--}}

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/product_status.js') }}"></script>
<script src="{{ asset('js/ajs/popup_product.js') }}"></script>

@yield('script')

</body>
</html>
