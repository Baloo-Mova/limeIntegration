@extends('frontend.layouts.template')

@section('content')

    <div class="container col-md-5 col-xs-9 col-sm-8">

        <div class="jumbotron">

            <h1 class="text-center">Вхoд</h1>


                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">E-Mail</label>
                        <div class="">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Пароль</label>

                        <div class="">
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                            <div class="checkbox">
                                <label for="checkboxes-0">
                                    <input type="checkbox" name="remember">
                                    Запомнить?
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> Вход
                            </button>

                            <a class="btn btn-link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
                        </div>
                    </div>
                </form>

        </div>
    </div>
@endsection
