@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Обработка анкет
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">

                    <div class="grid-view">

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