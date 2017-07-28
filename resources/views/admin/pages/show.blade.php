@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Просмотр страницы сайта
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <h1>Страница - "{{ $page->title }}"</h1>
                    <p>
                        {{ $page->page_content }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop