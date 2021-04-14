<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Monoton&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fugaz+One&display=swap');
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            span.cc {
                background-color: #646c70;
                color: white;
                border-radius: 10px;
                box-shadow: antiquewhite;
                box-shadow: #646c70 7px 9px 20px 0px;
            }
            span{
              font-family: 'Monoton', cursive;
            }
            span.hk{
              font-family: 'Fugaz One', cursive;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <span>S<span class="hk">H</span>op</span><span class="cc">boo<span class="hk">K</span></span>
                </div>

                <div class="links">
                    <a href="https://www.facebook.com/mohamed.korti/">Facebook</a>
                    <a href="https://laracasts.com">Documentation</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Contacts</a>
                    <a href="https://forge.laravel.com">Local</a>
                    <a href="https://vapor.laravel.com">About</a>
                    <a href="https://github.com/laravel/laravel">Services</a>
                </div>
            </div>
        </div>
    </body>
</html>
