@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Все опросы
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div>
                        <a href="{{ route('admin.messages.create') }}" class="btn btn-success center">Написать пользователю</a>
                    </div>

                    <hr/>


                    <div class="grid-view">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th><a class="" href="#">Название</a></th>
                                <th><a class="" href="#">Вознаграждение</a></th>
                                <th><a class="" href="#">Статус</a></th>
                                <th><a class="" href="#">Тип</a></th>
                                <th>Действия</th>
                            </tr>

                            </thead>
                            <tbody class='text-center'>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop