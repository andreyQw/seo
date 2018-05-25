<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NO-BS') }}</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/login_page_style.css')}}">

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
        .center_bloc {
            background-image: url({{ asset('img/bull_shit.png') }});
            background-position: center;
            background-color: #3b4685;
            background-repeat: no-repeat;
            margin-left: 0;
            margin-right: 0;
            height: 895px;
        }
        .circel_logo {
            position: absolute;
            top: -53px;
            left: 147px;
            background-image: url({{ asset('img/mini_bull.png') }});
            background-position: center;
            background-color: #f15d34;
            background-repeat: no-repeat;
            width: 106px;
            height: 106px;
            border-radius: 50%;
        }

        .a {
            background-image: url({{ asset('img/logo_footer.png') }});
            background-position: center;
            background-repeat: no-repeat;
            min-height: 150px;
            width: 17.9%;
        }
    </style>

</head>
<body>

{{--------- NAVIGATION BAR -----------}}
<nav class="navbar nobs_nav" role="navigation">

    <div class="container" style="padding-left: 0; padding-right: 0;">

        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="/img/logo.png" alt=""></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">EXAMPLES</a></li>
                <li><a href="#">HOW IT WORKS</a></li>
                <li><a href="#">AGENCIES</a></li>
                <li><a href="#">PRICING</a></li>
                <li><a href="#">BLOG</a></li>
                <li><a href="#" style="padding-right: 29px;">CONTACT</a></li>
                <li>

                    <a href="{{ route('addFormOrder') }}" class="btn btn-default navbar-btn btn-link">ORDER NOW</a>

                </li>
            </ul>
        </div>

    </div>

</nav>
{{---------- END NAVIGATION BAR ------------}}

{{------------ CENTER BLOCK --------------}}
<div class="row center_bloc">
    <div class="container with_login_form">
        <div class="form_cont" style="height: 450px;">

            <div class="panel-heading" style="padding-left: 0;padding-right: 0; text-align: center; color: #000; font-size: 18px;">Reset Password</div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" style="height: 28px; margin-bottom: 0;" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                                <input id="password" type="password" class="form-control" name="password" style="height: 28px;" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="control-label">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" style="height: 28px;" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-default" style="background-color: #f15d34; color: #fff; width: 100%; height: 50px;">
                                    Reset Password
                                </button>
                        </div>
                    </form>
                </div>

            <div class="circel_logo">

            </div>

        </div>
    </div>
</div>
{{-------------------- END CENTER BLOCK ----------------------}}

<div class="container" style="padding-left: 0; padding-right: 0; margin-top: 27px;">
    <div class="footer_sidebar a"></div>

    <div class="footer_sidebar b">
        <h3>Useful Links</h3>
        <div class="links_cont">
            <ul style="padding-right: 37px;">
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
            <span class="contact_info">help@nobs.link</span>
        </div>
    </div>

    <div class="footer_sidebar d">
        <h3>Recent From Blog</h3>
        <div class="blog_comment_cont">
            <img src="img/blog_avatar.png" alt="">
            <div class="comment_blog">
                <p style="margin-bottom: 7px;">Blog Title Name Dolor Site Ament</p>
                <p style="margin-bottom: 7px;">Is a Dummy Text</p>
            </div>
        </div>
        <hr>
        <div class="blog_comment_cont">
            <img src="img/blog_avatar.png" alt="">
            <div class="comment_blog">
                <p style="margin-bottom: 7px;">Blog Title Name Dolor Site Ament</p>
                <p style="margin-bottom: 7px;">Is a Dummy Text</p>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container" style="padding-left: 0; padding-right: 0; padding-top: 8px;">
        <hr>

        <div class="pays">
            <img src="/img/stripe.png" alt="">
            <img src="/img/mc.png" alt="">
            <img src="/img/visa.png" alt="">
            <img src="/img/ae.png" alt="">
        </div>
        <div class="copyright">
            <span style="font-size: 14px;">© 2017 All Rights Reserved&nbsp&nbsp|&nbsp&nbsp</span><a href="#" style="font-size: 14px; text-decoration: underline; color: #f15d34;">Terms & Conditions</a>
        </div>
    </div>
</footer>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>
</html>