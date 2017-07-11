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
    </head>
    <body id="top">
    <div id="main-content" class="liquid">
        <div class="liquid">

            @include('frontend.layouts.partials.header')

            <div id="content">
                <div class="content-wrapper">
                @yield('content')
                </div>
            </div>

            @include('frontend.layouts.partials.footer')
            </div>
        </div>

        @include('frontend.layouts.partials.scripts')
    </body>
</html>
