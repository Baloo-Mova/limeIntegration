@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center"><h2>@lang('messages.balance_page_title')</h2>
        <hr/>
        <div class="row  space">
            <div class="lead col-xs-4 col-sm-6 col-md-8"><span>@lang('messages.balance_page_available')</span>
                <span class="label label-success">{{Auth::user()->balance}}</span></div>
            <div class="col-xs-8 col-sm-6 col-md-4 text-right">
                @if(Auth::user()->balance > config('app.min_sum'))
                    <a href="{{url('/withdraws')}}">@lang('messages.balance_page_application_for_withdraw')</a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="lead col-xs-12 col-sm-12 col-md-12 text-danger">
                @lang('messages.balance_page_message1') <b>{{config('app.min_sum')}}</b>.
                @if(Auth::user()->balance < config('app.min_sum'))
                    @lang('messages.balance_page_message2') <b>{{config('app.min_sum')-Auth::user()->balance}}</b>.
                @endif
                <br>
                @lang('messages.balance_page_message3')
            </div>
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
    <script>

    </script>
@stop