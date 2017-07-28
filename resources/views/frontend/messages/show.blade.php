@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center">
        <h2>Сообщение <span class="message_date">{{ $message->created_at }}</span></h2>
            <p>
                {{ $text }}
            </p>
    </div>
@stop