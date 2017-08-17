@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Написать внутрисистемное сообщение
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">

                    <div class="col-md-4">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label for="date_birth" class="col-form-label">Заголовок страницы</label><br>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="col-xs-12">
                                    <label for="date_birth" class="col-form-label">Текст страницы</label><br>
                                    <textarea name="page_content" class="form-control"cols="30" rows="10" required></textarea>
                                </div>
                                <div class="col-xs-12 mt10">
                                    <button type="submit" class="btn btn-primary">Добавить</button>
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