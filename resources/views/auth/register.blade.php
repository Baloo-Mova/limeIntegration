@extends('frontend.layouts.template')

@section('content')
    <div class="signup" data-reactid=".0.0.1">
        <div class="auth-block-container container container-center" data-reactid=".0.0.1.0">
            <div class="row" data-reactid=".0.0.1.0.0">
                <div class="col-lg-3 col-md-2 col-sm-1"></div>
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <a href="{{url('/')}}" class="close fa fa-close" title="Вернуться на главную страницу"></a>
                    <h2>Регистрация</h2>
                    <!--<div class="oauth-signup">
                            <div>
                                <div class="btn btn-block btn-lg btn-default btn-vk button-social">
                                    <span class="fa fa-vk"></span>
                                    <span> Войти с помощью ВКонтакте</span></div>
                                <div class="btn btn-block btn-lg btn-default btn-facebook button-social">
                                    <span class="fa fa-facebook"></span>
                                    <span> Войти с помощью Facebook</span>
                                </div>
                                <div class="btn btn-block btn-lg btn-default btn-ok button-social">
                                    <span class="fa fa-ok"> </span>
                                    <span> Войти с помощью Одноклассники</span>
                                </div>
                            </div>
                            <div class="login-options-separator">
                                <span>или</span></div>
                        </div>-->
                    <form class="form-horizontal space" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">

                            <div class="col-xs-12" >
                                <label for="name" class="control-label">Имя*</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('second_name') ? ' has-danger' : '' }}">
                            <div class="col-xs-12" >
                                <label for="second_name" class="control-label">Фамилия*</label>
                                <input id="second_name" type="text" class="form-control" name="second_name"
                                       value="{{ old('second_name') }}">

                                @if ($errors->has('second_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('second_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="col-xs-12" >
                                <label for="email" class="control-label">E-Mail*</label>


                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="col-xs-12" >
                                <label for="password" class="control-label">Пароль*</label>


                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <div class="col-xs-12" >
                                <label for="password-confirm" class="control-label">Подтверждение пароля*</label>


                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                            <div class="col-xs-12" >
                                <label for="country" class="col-form-label">Страна*</label>
                                <select class="form-control" id="country" name="country">
                                    <option selected>Выбрать страну</option>
                                    @forelse($countries as $item)
                                        <option value="{{$item->country_id}}">{{$item->title}}</option>
                                    @empty
                                        <option selected>Нет стран</option>
                                    @endforelse
                                </select>
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('region') ? ' has-danger' : '' }}" id="regionSelect">
                            <div class="col-xs-12" >
                                <label for="country" class="col-form-label">Область(Штат)</label>
                                <select class="form-control" id="region" name="region">
                                    <option selected>Выбрать</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                @if ($errors->has('region'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('region') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}" id="citySelect">
                            <div class="col-xs-12" >
                                <label for="country" class="col-form-label">Город</label>
                                <select class="form-control" id="city" name="city">
                                    <option selected>Choose...</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date_birth') ? ' has-danger' : '' }}">
                            <div class="col-xs-12" >
                                <label for="date_birth" class="col-form-label">Дата рождения*</label>
                                <input class="form-control" type="date" value="ГГГГ-ММ-ДД" id="date_birth"
                                       name="date_birth">
                                @if ($errors->has('date_birth'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="auth-block-footer row space">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-lg btn-block">
                                    <i class="fa fa-btn fa-user"></i> Зарегистрироваться
                                </button>
                                <div class="small-space"></div>
                            </div>
                            <div class="col-md-6 text-right text-center-sm text-center-xs">
                                <div><a class="text-muted small"  href="{{url('login')}}">Вход в систему</a></div>
                                <div><a class="text-muted small" href="{{ url('/password/reset') }}" >Восстановление пароля</a></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="space"></div>
        </div>
    </div>




@endsection
@section('js')
    <script>
        var countryId = null;
        var regionId = null;
        $("#country").change(function () {
            countryId = $(this).val();
            $.getJSON("api/actualRegions/" + $(this).val(), function (jsonData) {
                select = '';
                // select += '<option selected> Выбрать</option>';
                $.each(jsonData, function (i, data) {
                    select += '<option value="' + data.region_id + '">' + data.title + '</option>';
                });
                select += '';
                $("#region").html(select);

            });


        });
        $("#region").change(function () {
            regionId = $(this).val();
            $.getJSON("api/actualCities/" + countryId + "?region_id=" + regionId, function (jsonData) {
                select = '';
                $.each(jsonData, function (i, data) {
                    select += '<option value="' + data.region_id + '">' + data.title + '</option>';
                });
                select += '';
                $("#city").html(select);
            });
        });
        /*$( "#city" ).click(function()
         {

         $.getJSON("api/actualCities/"+countryId+(regionId==null ? "" : "?region_id="+regionId), function(jsonData) {
         select = '';
         $.each(jsonData, function (i, data) {
         select += '<option value="' + data.region_id + '">' + data.title + '</option>';
         });
         select += '';
         $("#city").html(select);
         });
         });*/
    </script>

@stop
