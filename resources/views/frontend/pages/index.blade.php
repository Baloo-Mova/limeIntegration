@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center">
        <h2>{{ $page->title }}</h2>
        <p>
            {!! isset($page->page_content) ? $page->page_content:'' !!}
        </p>
    </div>


@stop

@section('css')
@stop

@section('js')
    <script>

    </script>

@stop