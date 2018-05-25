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
    <link href="{{ asset('css/orderForm.css') }}" rel="stylesheet">
    <link href="{{ asset('css/checkOut_page_style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">


    <!-- Script -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    {{--<script src="https://js.stripe.com/v3/"></script>--}}

    <style>
        @font-face {
            font-family: "HelveticaNeue";
            src: url("{{ asset('fonts/HelveticaNeue.ttf') }}") format("truetype");
            font-style: normal;
            font-weight: normal;
        }
        @font-face {
            font-family: "Helvetica Neue Medium";
            src: url("{{ asset('fonts/HelveticaNeue-Medium.ttf') }}");
        }
        @font-face {
            font-family: "Helvetica Neue Bold";
            src: url("{{ asset('fonts/HelveticaNeueBold.ttf') }}");
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }
    </style>
</head>
<body>

<div class="header">
    <div class="row">
        <nav class="navbar nobs_nav" role="navigation">

            <div class="container" style="padding-left: 0; padding-right: 0;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" style="background-color: #f05d34;">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar" style="background-color: #000000;"></span>
                            <span class="icon-bar" style="background-color: #000000;"></span>
                            <span class="icon-bar" style="background-color: #000000;"></span>
                        </button>
                    <a class="navbar-brand" href="{{ url('/') }}"><img src="{{asset('img/logo_white.png')}}" alt=""></a>
                </div>
                <div class="collapse navbar-collapse collapsed" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">EXAMPLES</a></li>
                        <li><a href="#">HOW IT WORKS</a></li>
                        <li><a href="#">AGENCIES</a></li>
                        <li><a href="#">PRICING</a></li>
                        <li><a href="#">BLOG</a></li>
                        <li><a href="#">CONTACT</a></li>
                        <li id="order-button"> <a href="{{ route('addFormOrder') }}" class="btn btn-default navbar-btn">ORDER NOW</a> </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container text_center">
        <div class="row">
            <div class="col-lg-12 col-h">
                <h1 class="h1">Place Order</h1>
            </div>
        </div>
    </div>
</div>

@yield('content')

<div class="container" style="padding-left: 0; padding-right: 0;">
    <div class="footer_sidebar a"></div>

    <div class="footer_sidebar b">
        <h3>Useful Links</h3>
        <div class="links_cont">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">About Us</a></li>
                <li><a href="">Examples</a></li>
                <li><a href="">How it Work</a></li>
            </ul>
            <ul>
                <li><a href="">Agencies</a></li>
                <li><a href="">Pricing</a></li>
                <li><a href="">Blog</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </div>
    </div>

    <div class="footer_sidebar c">
        <h3>Contact Us</h3>
        <div class="info_cont">
            <span class="contact_icon" style="background-image: url({{asset('img/location_icon.png')}});"></span>
            <span class="contact_info">Australian Office: 3-35 Mackey Street North Geelong VIC, AU 3215</span>
        </div>
        <div class="info_cont">
            <span class="contact_icon" style="background-image: url({{asset('img/phone_icon.png')}});"></span>
            <span class="contact_info">+1 855-205-4072</span>
        </div>
        <div class="info_cont">
            <span class="contact_icon" style="background-image: url({{asset('img/mail_icon.png')}});"></span>
            <span class="contact_info">support@nobslink.com</span>
        </div>
    </div>

    <div class="footer_sidebar d">
        <h3>Recent From Blog</h3>
        <div class="blog_comment_cont">
            <img src="{{asset('img/blog_avatar.png')}}" alt="">
            <div class="comment_blog">
                <p>Blog Title Name Dolor Site Ament</p>
                <p style="margin-bottom: 5px;">Is a Dummy Text</p>
            </div>
        </div>
        <hr>
        <div class="blog_comment_cont">
            <img src="{{asset('img/blog_avatar.png')}}" alt="">
            <div class="comment_blog">
                <p>Blog Title Name Dolor Site Ament</p>
                <p style="margin-bottom: 5px;">Is a Dummy Text</p>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container" style="padding-left: 0; padding-right: 0; padding-top: 8px;">
        <hr>

        <div class="pays">
            <img src="{{asset('img/stripe.png')}}" alt="">
            <img src="{{asset('img/mc.png')}}" alt="">
            <img src="{{asset('img/visa.png')}}" alt="">
            <img src="{{asset('img/ae.png')}}" alt="">
        </div>
        <div class="copyright">
            <span style="font-size: 14px;">© 2017 All Rights Reserved&nbsp&nbsp|&nbsp&nbsp</span><a href="#" style="font-size: 14px; text-decoration: underline; color: #f15d34;">Terms & Conditions</a>
        </div>
    </div>
</footer>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/ajs/inputQTY.js') }}"></script>
{{--<script src="{{ asset('js/order_calculate.js') }}"></script>--}}
<script></script>

<script>
    window.intercomSettings = {
        app_id: "xpsck7a1"
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

</body>
</html>