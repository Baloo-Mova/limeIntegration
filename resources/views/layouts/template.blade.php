<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="UTF-8">
        <title>Lime Integration</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        @include('frontend.layouts.partials.head')
    </head>
    <body>
        <div id="container">
            @include('frontend.layouts.partials.header')

            <div id="content">
                @yield('content')
            </div>

            @include('frontend.layouts.partials.footer')

        </div>
        @include('frontend.layouts.partials.scripts')
    </body>
</html>
