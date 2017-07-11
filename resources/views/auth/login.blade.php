@extends('frontend.layouts.template')

@section('content')


        <div class="login">
            <div class="auth-block-container container container-center">
                <div class="row">
                    <div class="col-lg-3 col-md-2 col-sm-1"></div>
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <a href="{{url('/')}}" class="close fa fa-close" title="Вернуться на главную страницу"></a>
                        <h2>Вход в систему</h2>
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
                        <form class="form-horizontal space" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-xs-12">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" placeholder="Адрес электронной почты">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-xs-12">
                                    <input id="password" type="password" class="form-control" name="password"
                                           placeholder="Пароль">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">


                                    <input type="checkbox" name="remember">
                                    <span>Запомнить?</span>


                                </div>
                            </div>
                            <div class="auth-block-footer row space">
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-lg btn-block">
                                        Войти
                                    </button>
                                    <div class="small-space"></div>
                                </div>
                                <div class="col-md-6 text-right text-center-sm text-center-xs">
                                    <div><a class="text-muted small" href="{{url('/register')}}">Регистрация</a>
                                    </div>
                                    <div><a class="text-muted small" href="{{ url('/password/reset') }}">Восстановление
                                            пароля</a></div>
                                </div>
                            </div>
                            <noscript></noscript>
                        </form>
                    </div>
                </div>
                <div class="space"></div>
            </div>
        </div>


@endsection
