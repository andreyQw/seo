<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NO-BS') }}</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/layout_dashboard_style.css')}}">
    <link rel="stylesheet" href="{{asset('css/jscroll.css')}}">
    <link rel="stylesheet" href="{{asset('css/user_manager_style.css')}}">
    <link rel="stylesheet" href="{{asset('css/switch_btn.css')}}">
    <link rel="stylesheet" href="{{asset('js/jquery-datatables-editable/datatables.css')}}">
    <link rel="stylesheet" href="{{asset('css/touchspin.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/2.1.99/css/materialdesignicons.css" media="all" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('css/setting_page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/acss/product_list.css') }}">
    <link rel="stylesheet" href="{{ asset('css/acss/client_all_orders.css') }}">


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

<div class="wrapper" id="main_cont_dash">

    <nav class="navbar navbar-fixed-top nobs_nav" role="navigation">

        <div class="nav_bar">
            <img src="{{ asset('img/logo.png') }}" alt="" class="mobile_logo_mob">
            <p class="navbar-text name_panel panel_role">


                @yield('name')</p>




            <div class="nav navbar-nav navbar-right nav_user_cont">

                <span class="notification_icon"><div id="circ_not"></div></span>
                <div class="photo_user" style="background-image: url('{{ asset('storage/photo_users/' . Auth::user()->photo) }}');">
                  <!-- <img src="{{ asset('storage/photo_users/' . Auth::user()->photo) }}" alt=""> -->
                    <div id="circ_online"></div>
                </div>
                <div class="name_user_nav">
                        <span style="line-height: 12px;">
                        {{ ucfirst(Auth::user()->first_name) . ' ' . ucfirst(Auth::user()->last_name) }}
                    </span>
                    <span>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="text-decoration: none">
                            <span style="display: inline-block; color: black; font-size: 12px; text-align: left;">Signout</span>
                        <span style="display: inline-block; color: black; text-align: left;" class="caret"></span>
                        </a>
                        </span>
                </div>
            </div>

            <div class="panel_role">
                @role('client')
                <div class="dropdown navbar-right navbar-nav nav">
                    <!--Button-ADD-NEW-WEBSITE-->
                    <button type="button" class="btn btn-success header-btn-add-website btn btn-default navbar-btn dropdown-toggle dropd_helper" data-toggle="dropdown" data-target="dropdown-menu-center">Add Website <span class="glyphicon glyphicon-triangle-bottom"></span></button>
                    @include('client.add_new_wesite')

                </div>
                @endrole
                @yield('button_navbar')
            </div>

        </div>

    </nav>


    <div class="container-fluid style_left_sidebar">
        <div class="navbar-header">
            <div class="form_navbar">
                <p class="navbar-text name_panel">@yield('name')</p>
                @role('client')
                <div class="dropdown navbar-right navbar-nav nav">
                    <!--Button-ADD-NEW-WEBSITE-->
                    <button type="button"  class="btn btn-success header-btn-add-website btn btn-default navbar-btn dropdown-toggle dropd_helper" data-toggle="dropdown" data-target="dropdown-menu-center">Add Website <span class="glyphicon glyphicon-triangle-bottom"></span></button>
                    @include('client.add_new_website_mobile')

                </div>


                @endrole
                @yield('button_navbar')
            </div>
            <button type="button" class="navbar-toggle collapsed mobile-button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="left_sidebar navbar-collapse collapse" aria-expanded="false" id="navbar" style="height: 100% !important;">
                <div class="sidebar-header"><img src="{{ asset('img/main_logo_dashboard.png') }}" alt=""></div>
                <div class="wrap">
                    <ul class="nav navbar-nav nav-sidebar " id="mobile-menu">

                        @role('client')
                        <li id="icon_sidebar_1" class="item_left_menu"><a href="{{ route('clients.index') }}"><i class="mdi mdi-home"></i>Dashboard</a></li>
                        <li id="icon_sidebar_2" class="item_left_menu"><a href="#websites_sidebar" data-toggle="collapse" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i>Websites</a></li>
                        <ul class="collapse opacha" id="websites_sidebar">
                            @foreach(Auth::user()->accounts as $acc)

                                @foreach($acc->projects as $project)
                                    <li class="item_left_menu"> <a href="{{ route('client.web',$project->id)}}"><span class="hide-menu">{{$project->url}}</span></a> </li>
                                @endforeach

                            @endforeach
                        </ul>
                        <li id="icon_sidebar_3" class="item_left_menu"><a href="{{ route('bio_manager') }}"><i class="mdi mdi-account"></i>Bio Manager</a></li>
                        <li id="icon_sidebar_4" class="item_left_menu"><a href="{{ route('link_anchor') }}"><i class="mdi mdi-link"></i>Link & Anchor Manager</a></li>
                        @endrole





                        @role('super_admin|admin|pm|production|partner')

                        <li id="icon_sidebar_9" class="item_left_menu"><a href="{{ route('feed') }}"><i class="mdi mdi-message-text"></i>News Feed</a></li>

                        @role('super_admin|admin|pm')

                        <li id="icon_sidebar_9" class="item_left_menu"><a href="{{ route('websites.index') }}"><i class="mdi mdi-web"></i>Website Manager</a></li>
                        @endrole

                        @role('super_admin|admin')
                        <li id="icon_sidebar_9" class="item_left_menu"><a href="{{ route('account.manager') }}"><i class="mdi mdi-clipboard-account"></i>Company Manager</a></li>

                        @endrole

                        @role('super_admin|admin|partner')
                        <li id="icon_sidebar_9" class="item_left_menu"><a href="{{ route('partners') }}"><i class="mdi mdi-account"></i>Partner Manager</a></li>
                        @endrole

                        @role('super_admin|admin|production|partner')

                          <li class="item_left_menu">
                                        <a href="#production_menu" id="opacha" data-toggle="collapse" data-parent="#mobile-menu" aria-expanded="false"><i class="mdi mdi-link"></i>Production manager<i class="mdi mdi-plus"></i><i class="mdi mdi-minus" style="display: none;"></i></a>


                        </li>
                        <ul class="collapse opacha" id="production_menu">
                            <li class="item_left_menu"><a href="{{ route('production.index') }}">Topic manager</a></li>
                            <li class="item_left_menu"><a href="{{ route('production.content_manager') }}">Content manager</a></li>
                            <li class="item_left_menu"><a href="{{ route('production.editor_manager') }}">Editor manager</a></li>
                            <li class="item_left_menu"><a href="{{ route('production.personalization_manager') }}">Personalization manager</a></li>
                            <li class="item_left_menu"><a href="{{ route('production.live_manager') }}">Go Live manager</a></li>
                        </ul>

                        @endrole


                        @role('super_admin|admin|pm|production')

                       <li class="item_left_menu">
                                        <a href="#bio_anchor_menu" data-toggle="collapse" aria-expanded="false"><i class="mdi mdi-account"></i>Bio & Link Manager<i class="mdi mdi-plus"></i><i class="mdi mdi-minus" style="display: none;"></i></a>

                        </li>
                        <ul class="collapse opacha" id="bio_anchor_menu">
                            <li class="item_left_menu"><a href="{{ route('bio_request') }}">Request Bio Manager</a></li>


                            @role('super_admin|admin|pm')
                            <li class="item_left_menu"><a href="{{ route('bio_manager') }}">Bio Manager</a></li>
                            <li class="item_left_menu"><a href="{{ route('link_anchor') }}">Link & Anchor Manager</a></li>
                            @endrole

                        </ul>

                        @endrole

                        @role('super_admin|admin')

                                    <li class="item_left_menu">
                                        <a href="#reports" data-toggle="collapse" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i>Reports<i class="mdi mdi-plus"></i><i class="mdi mdi-minus" style="display: none;"></i></a>


                        </li>
                        <ul class="collapse opacha" id="reports">
                            <li class="item_left_menu"><a href="{{ route('sales') }}">Sales Report</a></li>
                        </ul>

                                    <li class="item_left_menu">
                                        <a href="#orders" data-toggle="collapse" aria-expanded="false"><i class="mdi mdi-cart-plus"></i>Orders & Products <i class="mdi mdi-plus"></i><i class="mdi mdi-minus" style="display: none;"></i></a>

                        </li>
                        <ul class="collapse opacha" id="orders">
                            <li class="item_left_menu"><a href="{{ route('allOrdersClient') }}">Order Manager</a></li>
                            <li class="item_left_menu"><a href="{{ url('product/list') }}">Product Manager</a></li>
                        </ul>

                                    <li id="icon_sidebar_8" class="item_left_menu"><a href="#report_menu" data-toggle="collapse" aria-expanded="false"><i class="mdi mdi-account"></i>Admin<i class="mdi mdi-plus"></i><i class="mdi mdi-minus" style="display: none;"></i></a>

                        </li>
                        <ul class="collapse opacha" id="report_menu">
                            <li class="item_left_menu"><a href="{{ route('staff_manager') }}">Staff Manager</a></li>
                            <li class="item_left_menu"><a href="{{ route('coupon.index') }}">Coupon Manager</a></li>
                        </ul>
                        @endrole

                        @endrole

                        @role('editor|writer')
                        <li id="icon_sidebar_9" class="item_left_menu"><a href="{{ route('feed') }}"><i class="mdi mdi-message-text"></i>News Feed</a></li>
                        @role('writer')
                        <li id="icon_sidebar_9" class="item_left_menu"><a href="{{ route('production.content_manager') }}"><i class="mdi mdi-message-text"></i>Production</a></li>
                        @endrole
                        @role('editor')
                        <li id="icon_sidebar_9" class="item_left_menu"><a href="{{ route('production.editor_manager') }}"><i class="mdi mdi-message-text"></i>Production</a></li>
                        @endrole
                        @endrole

                        <footer>
                            <ul class="nav footer_bar">
                                <li id="footer_sidebar_1" class="item_left_menu">
                                    <a href="{{ route('settings') }}">
                                        <i class="mdi mdi-settings power"></i>Setting</a>
                                </li>
                                <li id="footer_sidebar_2">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="mdi mdi-power"></i>Logout
                                    </a>
                                </li>

                            </ul>
                        </footer>
                    </ul>

                    </footer>
                    </ul>
                </div>
            </div>


        </div>

        <div class="container-fluid left-sidebar-bgr">
            <div class="col-sm-12 col-md-12 main">

                @yield('content')

            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/touchspin.js') }}"></script>

    @role('client')

    <script src="{{ asset('js/ajs/add_webSite_mobile.js') }}"></script>
    <script src="{{ asset('js/ajs/add_webSite.js') }}"></script>
    <script>
        $(document).on('click.bs.dropdown.data-api', '#add_website_drop', function (e) {
            e.stopPropagation();
        });
    </script>
    <script>
        window.intercomSettings = {
            app_id: "xpsck7a1",
            name: '{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}', // Full name
            email: '{{ Auth::user()->email }}', // Email address
            created_at: {{ strtotime((new \DateTime())->format('Y-m-d H:i:s')) }} // Signup date as a Unix timestamp
        };
    </script>
    <script>
        (function(){
            var w=window;
            var ic=w.Intercom;
            if(typeof ic==="function"){
                ic('reattach_activator');
                ic('update',intercomSettings);
            }else{
                var d=document;
                var i=function(){
                    i.c(arguments)
                };
                i.q=[];
                i.c=function(args){
                    i.q.push(args)
                };
                w.Intercom=i;
                function l(){
                    var s=d.createElement('script');
                    s.type='text/javascript';
                    s.async=true;
                    s.src='https://widget.intercom.io/widget/xpsck7a1';
                    var x=d.getElementsByTagName('script')[0];
                    x.parentNode.insertBefore(s,x);
                }
                if(w.attachEvent){
                    w.attachEvent('onload',l);
                }else{
                    w.addEventListener('load',l,false);
                }
            }
        })();
    </script>
    @endrole

    <script>
        jQuery.each($('.item_left_menu'), function (n) {
            if($(this).children()[0].href == window.location.origin + window.location.pathname){
                $(this).attr('class', 'active');
                if($(this).parent()[0].className == 'collapse opacha'){
                    $($(this).parent()[0]).attr('class', 'collapse in opacha');
                    $($('a[href="#' + $(this).parent()[0].id + '"]').parent()[0]).attr('class', 'active');
                    $($('a[href="#' + $(this).parent()[0].id + '"]')[0]).find('i.mdi-plus').hide();
                    $($('a[href="#' + $(this).parent()[0].id + '"]')[0]).find('i.mdi-minus').show();
                }
            }
        });

        jQuery.each($('.opacha'), function (n) {
            $(this).on('show.bs.collapse', function (e) {
                $($('a[href="#' + $(e.target).attr('id') + '"]')[0]).find('i.mdi-plus').hide();
                $($('a[href="#' + $(e.target).attr('id') + '"]')[0]).find('i.mdi-minus').show();
            });
            $(this).on('hidden.bs.collapse', function (e) {
                $($('a[href="#' + $(e.target).attr('id') + '"]')[0]).find('i.mdi-minus').hide();
                $($('a[href="#' + $(e.target).attr('id') + '"]')[0]).find('i.mdi-plus').show();
            });
        });
    </script>

    @yield('script')
</div>
</body>

</html>
