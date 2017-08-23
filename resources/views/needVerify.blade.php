@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center">
        <h2>@lang('messages.needVerify')</h2>
        <h4>@lang('messages.verifyNoEmail') <a href="{{ route('verify.email.repeat', ["user_id" => Auth::user()->id]) }}">@lang('messages.emailRepeat')</a></h4>
        <a href="{{ route('site.welcome') }}">@lang('messages.back_to_main')</a>
    </div>


        @stop

        @section('css')
        @stop

        @section('js')
            <script>

            </script>

@stop