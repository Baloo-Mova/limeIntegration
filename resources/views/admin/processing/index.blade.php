@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Обработка анкет
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                            <h4>Выгрузка пройденных анкет</h4>
                        <div class="grid-view">
                            <a href="{{ route('admin.surveys.processing.finished.worksheets') }}" class="btn btn-success">Выгрузить</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Выгрузка не пройденных анкет</h4>
                        <div class="grid-view">
                            <a href="" class="btn btn-success">Выгрузить</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Выгрузка всех анкет</h4>
                        <div class="grid-view">
                            <a href="" class="btn btn-success">Выгрузить</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $(".modal").modal('hide');
            $(".call_modal").on("click", function () {
                var money = $(this).data("money"),
                    sid = $(this).data("sid");

                $(".money").val(money);
                $(".sid").val(sid);
            });
        });
    </script>
@stop