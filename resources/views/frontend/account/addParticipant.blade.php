@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>   Добавить текущего пользователя к опросу
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <form action="" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-xs-12 ">
                                <label for="survey" class="control-label">Survey id</label>
                                <input id="survey" type="text" class="form-control" name="survey" required>
                            </div>
                            <div class="col-xs-3 ">
                                <button type="submit" class="btn btn-success btn-block mt10">
                                    Добавить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop