@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Редактирование страницы
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">

                    <div class="col-md-4">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="page_id" value="{{ $page->id }}">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="date_birth" class="col-form-label">Заголовок страницы</label><br>
                                    <input type="text" name="title" class="form-control"  value="{{ $page->title }}" required>
                                </div>
                                <div class="col-xs-12">
                                    <label for="date_birth" class="col-form-label">Имя страницы</label><br>
                                    <input type="text" name="name" class="form-control"  value="{{ $page->name }}" required>
                                </div>
                                <div class="col-xs-12">
                                    <label for="date_birth" class="col-form-label">Текст страницы</label><br>
                                    <textarea name="page_content" class="form-control"cols="30" rows="10" required>{{$page->page_content}}</textarea>
                                </div>
                                <div class="col-xs-12 mt10">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop