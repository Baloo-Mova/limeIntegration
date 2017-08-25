@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>  Админ. Просмотр Пользователя.
    <span>ID: {{$user->id}}</span>
@endsection

@section('main-content')
    <hr/>


    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('admin.send.base.messages.list') }}" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Написать пользователю</h4>
                            </div>
                            <div class="modal-body">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="participant[0]" value="{{ $user->ls_participant_id }}">
                                    <div class="form-group">
                                        <label for="date_birth" class="col-form-label">Сообщение</label><br>
                                        <textarea name="text" class="form-control" required></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-primary">Отправить сообщение</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                                    <h4>Страна: <small class="text-muted">{{$user->country->title}}</small></h4>
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
                                        <div class="btn-group">
                                            <a href="" data-toggle="modal" data-target="#sendModal" class="btn btn-success">Написать пользователю</a>
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
