@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-angle-double-right'></i>  Админ. Главная.
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">




                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
    <script>

    </script>
    <script>
        $(document).ready(function() {
            $("#myModalBox").modal('show');
        });
    </script>
@stop