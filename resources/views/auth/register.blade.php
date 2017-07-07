@extends('frontend.layouts.template')

@section('content')
    <div class="container col-md-5 col-xs-9 col-sm-8">
        <div class="jumbotron">


                <div class="">
                    <h1 class="text-center">Регистрация</h1>


                    <form class="" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">


                            <label for="name" class="control-label">Имя</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('second_name') ? ' has-danger' : '' }}">
                            <label for="second_name" class="control-label">Фамилия</label>
                            <input id="second_name" type="text" class="form-control" name="second_name"
                                   value="{{ old('second_name') }}">

                            @if ($errors->has('second_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('second_name') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="email" class="control-label">E-Mail</label>


                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <label for="password" class="control-label">Пароль</label>


                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <label for="password-confirm" class="control-label">Подтверждение пароля</label>


                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif

                        </div>

                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                            <label for="country" class="col-form-label">Страна</label>
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
                        <div class="form-group{{ $errors->has('region') ? ' has-danger' : '' }}" id="regionSelect">
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
                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}" id="citySelect">
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

                        <div class="form-group{{ $errors->has('date_birth') ? ' has-danger' : '' }}">
                            <label for="date_birth" class="col-form-label">Дата рождения</label>
                            <input class="form-control" type="date" value="2011-08-19" id="date_birth"
                                   name="date_birth">
                            @if ($errors->has('date_birth'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('date_birth') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Зарегистрироваться
                                </button>
                            </div>
                        </div>
                    </form>

                </div>

        </div>
    </div>
@endsection
@section('js')
    <script>
        var countryId = null;
        var regionId = null;
        $( "#country" ).change(function()
        {
            countryId = $(this).val();
            $.getJSON("api/actualRegions/"+ $(this).val() , function(jsonData) {
                select = '';
               // select += '<option selected> Выбрать</option>';
                $.each(jsonData, function (i, data) {
                    select += '<option value="' + data.region_id + '">' + data.title + '</option>';
                });
                select += '';
                $("#region").html(select);

            });


        });
        $( "#region" ).change(function()
        {
            regionId = $(this).val();
            $.getJSON("api/actualCities/"+countryId+"?region_id="+regionId, function(jsonData) {
                select = '';
                $.each(jsonData, function (i, data) {
                    select += '<option value="' + data.region_id + '">' + data.title + '</option>';
                });
                select += '';
                $("#city").html(select);
            });
        });
        $( "#city" ).click(function()
        {

            $.getJSON("api/actualCities/"+countryId+(regionId==null ? "" : "?region_id="+regionId), function(jsonData) {
                select = '';
                $.each(jsonData, function (i, data) {
                    select += '<option value="' + data.region_id + '">' + data.title + '</option>';
                });
                select += '';
                $("#city").html(select);
            });
        });
    </script>

@stop
