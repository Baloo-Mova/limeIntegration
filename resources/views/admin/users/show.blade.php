@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>  Админ. Просмотр Пользователя.
    <span>ID: {{$user->id}}</span>
@endsection

@section('main-content')
    <hr/>


    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="card">
                        <div class="card-block">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <a href="#">
                                        <img class="media-object" src="http://dummyimage.com/150x150" alt="...">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4>Права: <small class="text-muted">{{$user->role->title}}</small></h4>
                                    <h4>Имя: <small class="text-muted">{{$user->name}}</small></h4>
                                    <h4>Фамилия: <small class="text-muted">{{$user->second_name}}</small></h4>
                                    <h4>Почта: <small class="text-muted">{{$user->email}}</small></h4>
                                    <h4>Баланс: <small class="text-muted">{{$user->balance}} ₽</small></h4>
                                    <h4>Рейтинг: <small class="text-muted">{{$user->rating}}</small></h4>
                                    <h4>Страна: <small class="text-muted">{{$user->country->first()->title}}</small></h4>
                                    <h4>Область(Штат): <small class="text-muted">{{isset($user->region->title) ? $user->region->title : ""}}</small></h4>
                                    <h4>Город: <small class="text-muted">{{isset($user->city->title) ? $user->city->title : ""}}</small></h4>
                                    <h4>Дата рождения: <small class="text-muted">{{$user->date_birth}}</small></h4>
                                    <h4>Дата регистрации: <small class="text-muted">{{$user->created_at}}</small></h4>
                                    <h4>Дата последнего обновления: <small class="text-muted">{{$user->updated_at}}</small></h4>

                                    <div class="btn-toolbar">

                                        <div class="btn-group">
                                            <a href="{{ route('admin.users.edit', ['id'=>$user->id]) }}"
                                               class="btn-primary btn">Обновить</a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.users.delete', ['id'=>$user->id]) }}"
                                               onclick="return confirm('Вы точно хотите удалить этого пользователя')"
                                               class="btn-danger btn">Удалить</a>
                                        </div>


                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@stop
@section('js')

@stop
