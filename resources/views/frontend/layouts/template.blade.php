<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ Illuminate\Support\Facades\Lang::getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lime integrator</title>
        @include('frontend.layouts.partials.head')
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        html,
        body,
        .wrapper {
            height: 100%;
        }
        .content {
            box-sizing: border-box;
            min-height: 100%;
            padding-bottom: 150px;
            background-color: #F8F8FA;
        }
        .footer {
            height: 150px;
            margin-top: -150px;
        }
    </style>
    </head>
    <body id="top">

    <div class="wrapper">


        <div class="content">
            @include('frontend.layouts.partials.header')
            @yield('content')
        </div>

        <div class="footer">
            <div class="container-fluid">
                @include('frontend.layouts.partials.footer')
            </div>
        </div>

    </div>

    @include('frontend.layouts.partials.scripts')
    </body>
</html>
