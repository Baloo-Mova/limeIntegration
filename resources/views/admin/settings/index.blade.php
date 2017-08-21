@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>   Настройки
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="box box-primary">
                <div class="box-body">

                    <form action="{{route('admin.settings.store')}}">
                        <
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop