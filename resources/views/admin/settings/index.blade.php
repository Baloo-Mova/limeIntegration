@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>   Настройки
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <form action="{{route('admin.settings.store')}}" method="post">
                {{ csrf_field() }}
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box box-primary" style="height: 230px;">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="min_sum">Минимальная сумма, которую пользователь может вывести с проэкта.</label>
                                        </div>
                                        <div class="form-group col-md-7">
                                            <input type="text" name="min_sum" class="form-control" id="min_sum" value="{{ isset($settings) ? $settings->min_sum : 0 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box box-primary" style="height: 230px;">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="min_sum">Выражения (текст, помещенный в квадратные скобки <strong>[text]</strong>) в тексте письма, которые будут заменены на соответствующие значения.</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <ul class="admin_settings_ul">
                                                <li><strong>[name]</strong> - будет заменено на имя пользователя, которому отправляется письмо;</li>
                                                <li><strong>[surname]</strong> - будет заменено на фамилию пользователя, которому отправляется письмо;</li>
                                                <li><strong>[surveylink]</strong> - будет заменено ссылкой на прохождение опроса;</li>
                                                <li><strong>[resetlink]</strong> - будет заменено ссылкой для восстановления пароля;</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="min_sum">Текст письма, которое отправляется при добавлении пользователя к новому опросу.</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea name="new_message_text" class="form-control" rows="15" id="new_message_text">{{ isset($settings) ? $settings->new_message_text : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="min_sum">Текст письма, которое отправляется, как напоминание о непройденном опросе.</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea name="remind_message_text" class="form-control" rows="15" id="remind_message_text">{{ isset($settings) ? $settings->remind_message_text : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="min_sum">Текст письма, которое отправляется, при запросе сброса пароля.</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <textarea name="reset_password_message_text" class="form-control" rows="15" id="remind_message_text">{{ isset($settings) ? $settings->reset_password_message_text : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary" style="height: 230px;">
                                <div class="box-body">
                                    <div class="form-group col-md-12">
                                        <label for="">При изменении любого параметра в настройках, нажмите "Сохранить настройки"</label>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary">Сохранить настройки</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
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
                            <div class="box-body">
                                <form action="{{route('admin.settings.save.smtp')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group col-md-12">
                                        <label for="smtp" class="col-form-label">Smtp</label><br>
                                        <input type="text" name="smtp" id="smtp" class="form-control origin-smtp" value="{{ isset($settings) ? $settings->smtp : 0 }}" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="port" class="col-form-label">Порт</label><br>
                                        <input type="text" name="smtp_port" id="port" class="form-control origin-port" value="{{ isset($settings) ? $settings->smtp_port : 0 }}" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="login" class="col-form-label">Логин</label><br>
                                        <input type="text" name="smtp_login" id="login" class="form-control origin-login" value="{{ isset($settings) ? $settings->smtp_login : 0 }}" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="pasw" class="col-form-label">Пароль</label><br>
                                        <input type="password" name="smtp_pasw" id="pasw" class="form-control origin-pasw" value="{{ isset($settings) ? $settings->smtp_pasw : 0 }}" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <a href="#" class="btn btn-success test-button" data-toggle="modal" data-target="#testModal">Проверить SMTP</a>
                                        <button type="submit" class="btn btn-default">Сохранить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

            var editor_config = {
                path_absolute : "/",
                selector: "textarea",
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                relative_urls: false,
                file_browser_callback : function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                    if (type == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.open({
                        file : cmsURL,
                        title : 'Filemanager',
                        width : x * 0.8,
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no"
                    });
                }
            };
            tinymce.init(editor_config);
        });
    </script>
@stop