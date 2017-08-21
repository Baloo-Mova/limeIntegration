@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>   Настройки
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <form action="{{route('admin.settings.store')}}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="min_sum">Минимальная сумма вывода</label>
                                    <input type="text" name="min_sum" class="form-control" id="min_sum" value="{{ isset($settings) ? $settings->min_sum : 0 }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="new_message_text">Текст письма о новом сообщении</label>
                                    <textarea name="new_message_text" class="form-control" id="new_message_text">{{ isset($settings) ? $settings->new_message_text : '' }}</textarea>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="new_message_text">Выражения, которые будут заменены</label>
                                    <ul class="admin_settings_ul">
                                        <li>[name]</li>
                                        <li>[surname]</li>
                                        <li>[link]</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="remind_message_text">Текст письма-напоминания</label>
                                    <textarea name="remind_message_text" class="form-control" id="remind_message_text">{{ isset($settings) ? $settings->remind_message_text : '' }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-default">Сохранить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Modal -->
                <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

                    <form action="{{route('admin.settings.check.smtp')}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Проверить SMTP</h4>
                                </div>
                                <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="smtp" class="col-form-label">E-mail получателя</label><br>
                                                <input type="text" name="email" id="smtp" class="form-control" required>
                                            </div>
                                        </div>
                                        <input type="hidden" name="smtp" class="test-smtp">
                                        <input type="hidden" name="port" class="test-port">
                                        <input type="hidden" name="login" class="test-login">
                                        <input type="hidden" name="smtp_pasw" class="test-pasw">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="text">Текст тестового письма</label>
                                                <textarea name="text" class="form-control" id="text"></textarea>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn btn-default" data-dismiss="modal">Отмена</a>
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <form action="{{route('admin.settings.save.smtp')}}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="smtp" class="col-form-label">Smtp</label><br>
                                    <input type="text" name="smtp" id="smtp" class="form-control origin-smtp" value="{{ isset($settings) ? $settings->smtp : 0 }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="port" class="col-form-label">Порт</label><br>
                                    <input type="text" name="smtp_port" id="port" class="form-control origin-port" value="{{ isset($settings) ? $settings->smtp_port : 0 }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="login" class="col-form-label">Логин</label><br>
                                    <input type="text" name="smtp_login" id="login" class="form-control origin-login" value="{{ isset($settings) ? $settings->smtp_login : 0 }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="pasw" class="col-form-label">Пароль</label><br>
                                    <input type="password" name="smtp_pasw" id="pasw" class="form-control origin-pasw" value="{{ isset($settings) ? $settings->smtp_pasw : 0 }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <a href="#" class="btn btn-success test-button" data-toggle="modal" data-target="#testModal">Проверить SMTP</a>
                                    <button type="submit" class="btn btn-default">Сохранить</button>
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
    <script>
        $(document).ready(function(){
           $(".test-button").on("click", function(){
              var smtp = $(".origin-smtp").val(),
                  port = $(".origin-port").val(),
                  login = $(".origin-login").val(),
                  pasw = $(".origin-pasw").val();
              $(".test-smtp").val(smtp);
              $(".test-port").val(port);
              $(".test-login").val(login);
              $(".test-pasw").val(pasw);
           });
        });
    </script>
@stop