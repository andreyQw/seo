<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NO-BS') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/orders_layout_style.css') }}" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-offset-1 col-xs-10 header_panel">
        <div class="container-fluid">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <div>
                    <img src="img/logo.png" alt="">
                </div>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9 nav_cont">
                <div class="nav_panel">
                    <ul>
                        <li><a href="#">EXAMPLES</a></li>
                        <li><a href="#">HOW IT WORKS</a></li>
                        <li><a href="#">AGENCIES</a></li>
                        <li><a href="#">PRICING</a></li>
                        <li><a href="#">BLOG</a></li>
                        <li><a href="#">CONTACT</a></li>
                    </ul>
                    <div class="btn_order">
                        <a href="{{ route('addFormOrder') }}">
                            <button type="button" id="order_now"><span>ORDER NOW</span></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <div class="col-md-offset-2 col-md-8 footer" style="padding-bottom: 20px;">
        <div class="container-fluid" style="margin-top: 25px; border-bottom: 1px solid #acacac; padding: 0 0 20px 0;">
            <div class="col-md-3 logo_footer">
                <div>
                    <img src="http://nobslink/img/main_logo_dashboard.png" alt="">
                </div>
            </div>
            <div class="col-md-3 links_cont">
                <h3>Useful Links</h3>
                <div class="container-fluid pages_footer">
                    <div class="col-md-6">
                        <ul>
                            <li><a href="">Home</a></li>
                            <li><a href="">About Us</a></li>
                            <li><a href="">Examples</a></li>
                            <li><a href="">How it Work</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 pages_footer" style="padding-left: 15px;">
                        <ul>
                            <li><a href="">Agencies</a></li>
                            <li><a href="">Pricing</a></li>
                            <li><a href="">Blog</a></li>
                            <li><a href="">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 contacts_cont">
                <h3>Contact Us</h3>
                <div class="container-fluid contacts_info">
                    <div class="col-md-1" style="padding-left: 0;"><span style="margin-top: 2px; width: 15px; height: 15px; background-repeat: no-repeat; display: block; background-image: url({{asset('img/location_icon.png')}});"></span></div>
                    <div class="col-md-11" style="padding: 0 0 10px 3px;">Australian Office: 3-35 Mackey Street North Geelong VIC, AU 3215</div>
                    <div class="col-md-1" style="padding-left: 0;"><span style="margin-top: 2px; width: 15px; height: 15px; background-repeat: no-repeat; display: block; background-image: url({{asset('img/phone_icon.png')}});"></span></div>
                    <div class="col-md-11" style="padding: 0 0 10px 3px;">+1 855-205-4072</div>
                    <div class="col-md-1" style="padding-left: 0;"><span style="margin-top: 2px; width: 17px; height: 15px; background-repeat: no-repeat; display: block; background-image: url({{asset('img/mail_icon.png')}});"></span></div>
                    <div class="col-md-11" style="padding: 0 0 10px 3px;">support@nobslink.com</div>
                </div>
            </div>
            <div class="col-md-3 blog_main_cont" style="padding-right: 0;">
                <h3>Recent From Blog</h3>
                <div class="container-fluid blog_cont">
                    <div class="col-md-12">
                        <div class="col-md-2 avatar_blog_cont"><img src="img/blog_avatar.png" alt=""></div>
                        <div class="col-md-9 blog_text"><p>Blog Titile Name Dolor Site Ament</p><p>Is a Dummy Text</p></div>
                    </div>
                    <div class="col-md-12" style="border-bottom: 2px solid #e6e6e6; margin-bottom: 10px;">

                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2 avatar_blog_cont"><img src="img/blog_avatar.png" alt=""></div>
                        <div class="col-md-9 blog_text"><p>Blog Titile Name Dolor Site Ament</p><p>Is a Dummy Text</p></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="col-md-4 col-md-offset-4" style="margin-top: 25px; text-align: center;">
                <img src="img/stripe.png" alt="">
                <img src="img/mc.png" alt="">
                <img src="img/visa.png" alt="">
                <img src="img/ae.png" alt="">
            </div>
            <div class="col-md-offset-3 col-md-6" style="text-align: center; margin-top: 15px;">
                <span style="font-weight: 600; font-size: 13px;">© 2017 All Rights Reserved &nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp   </span><a href="#" style="font-size: 13px; text-decoration: underline; color: #f15d34;">Terms & Conditions</a>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>