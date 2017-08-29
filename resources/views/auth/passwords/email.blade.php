@extends('frontend.layouts.template')

<!-- Main Content -->
@section('content')
    <div class="recover-password">
        <div class="auth-block-container container container-center">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-sm-1"></div>
                <div class="col-lg-6 col-md-8 col-sm-10">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{url('/')}}" class="close fa fa-close" title="Вернуться на главную страницу"></a>
                    <h2>Восстановление пароля</h2>
                    <div>
                        <form class="form-horizontal  space" role="form" method="POST"
                              action="{{ url('/password/email') }}">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-xs-12">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" placeholder="Укажите email Вашего акканута">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                            <div class="auth-block-footer row space">
                                <div class="col-md-6">
                                    <button class="btn btn-success btn-lg" type="submit">
                                        Выслать инструкции на почту
                                    </button>
                                    <div class="small-space"></div>
                                </div>
                                <div class="col-md-6 text-right text-center-sm text-center-xs">
                                    <div><a class="text-muted small" href="{{ url('/login') }}">Вход</a></div>
                                    <div><a class="text-muted small" href="{{url('/register')}}">Регистрация</a></div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="space"></div>
        </div>
    </div>



@endsection
