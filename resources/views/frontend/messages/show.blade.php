@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center">
        <h2>@lang('messages.message') <span class="message_date">{{ $message->created_at }}</span></h2>
            <p>
                {!! htmlspecialchars_decode($text) !!}
            </p>
    </div>
@stop