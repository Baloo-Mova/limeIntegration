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
                                    <label for="date_birth" class="col-form-label">Респондент</label><br>
                                    <select name="user" id="" class="form-control" required>
                                        <option value="">Выберите пользователя</option>
                                        @foreach($users as $user)
                                            @if($user->name != "admin")
                                                <option value="{{ $user->id }}">{{ $user->name." ".$user->second_name  }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-12">
                                    <label for="date_birth" class="col-form-label">Сообщение</label><br>
                                    <textarea name="text" class="form-control" required></textarea>
                                </div>
                                <div class="col-xs-12 mt10">
                                    <button type="submit" class="btn btn-primary">Отправить</button>
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