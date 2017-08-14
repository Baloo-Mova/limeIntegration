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
                                    <select name="user[]" id="" class="form-control select_user" required multiple="multiple">
                                        <option value="">Выберите пользователя</option>
                                        @foreach($users as $user)
                                            @if($user->name != "admin")
                                                <option value="{{ $user->id }}">{{ $user->name." ".$user->second_name  }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-12">
                                    <label for="date_birth" class="col-form-label">Отправить всем</label><br>
                                    <input type="checkbox" name="send_all" class="send_all">
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

@section('css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            color: #1c1c1c;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function () {
           $(".select_user").select2();
            $(".send_all").bootstrapSwitch();
        });
        $('.send_all').on('switchChange.bootstrapSwitch', function(event, state) {
            if(state){
                $(".select_user").attr("disabled", true);
            }else{
                $(".select_user").attr("disabled", false);
            }
        });
    </script>
@stop