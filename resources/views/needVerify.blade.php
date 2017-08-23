@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center">
        <h2>@lang('messages.needVerify')</h2>
        <a href="{{ route('site.welcome') }}">@lang('messages.back_to_main')</a>
    </div>


        @stop

        @section('css')
        @stop

        @section('js')
            <script>

            </script>

@stop