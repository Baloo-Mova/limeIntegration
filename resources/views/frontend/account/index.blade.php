@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>   Админ. Список зарегистрованных пользователей
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">

                    <div>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-danger center">Создать</a>
                    </div>

                    <hr/>

                    <div class="grid-view ">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th><a class="" href="#">Имя Фамилия</a></th>
                                <th><a class="" href="#">Почта</a></th>
                                <th><a class="" href="#">Баланс</a></th>
                                <th><a class="" href="#">Страна</a></th>

                                <th><a class="" href="#">Дата создания</a></th>
                                <th><a class="" href="#"></a></th>

                            </tr>

                            </thead>
                            <tbody class='text-center'>
                            @foreach($users as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name." ".$item->second_name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->balance}}</td>
                                    <td>{{$item->country->first()->title}}</td>


                                    <td>{{$item->created_at}}</td>

                                    <td>
                                        <a href="{{route('admin.users.show', [$item->id])}}" title="View"
                                           aria-label="View"
                                           data-pjax="0">
                                            <span class="fa fa-eye"></span>
                                        </a>

                                        <a href="{{route('admin.users.edit', [$item->id])}}" title="Update"
                                           aria-label="Update"
                                           data-pjax="0">
                                            <span class="fa fa-pencil"></span></a>

                                        <a href="{{ route('admin.users.delete', ['id'=>$item->id]) }}"
                                           title="Delete"
                                           aria-label="Delete"
                                           data-confirm="Вы точно хотите удалить платежную систему?"
                                           data-method="post" data-pjax="0">
                                            <span class="fa fa-trash"></span>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>

                    {!! $users->links() !!}

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop