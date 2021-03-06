@extends('frontend.layouts.template')

@section('content')


    <div class="signup">
        <div class="auth-block-container container container-center">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-sm-1"></div>
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <h2>Изменение пользователя</h2>
                    @if($errors->has('needFull'))
                        <span style="color: red;">* @lang('auth.needFull') </span>
                    @endif
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal">
                        {{ csrf_field() }}


                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">

                            <div class="col-xs-12">
                                <label for="name" class="control-label">Имя*</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('second_name') ? ' has-danger' : '' }}">
                            <div class="col-xs-12">
                                <label for="second_name" class="control-label">Фамилия*</label>
                                <input id="second_name" type="text" class="form-control" name="second_name"
                                       value="{{ $user->second_name }}">

                                @if ($errors->has('second_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('second_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
                            <div class="col-xs-12">
                                <label for="country" class="col-form-label">Пол*</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option selected>Выберите пол</option>
                                    <option value="0" {{ $user->gender == 0 ? "selected" : "" }}>Мужской</option>
                                    <option value="1" {{ $user->gender == 1 ? "selected" : "" }}>Женский</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="col-xs-12">
                                <label for="email" class="control-label">E-Mail*</label>


                                <input id="email" type="email" class="form-control" name="email"
                                       value="{{ $user->email }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('country') ? ' has-danger' : '' }}">
                            <div class="col-xs-12">
                                <label for="country" class="col-form-label">Страна*</label>
                                <select class="form-control" id="country" name="country">
                                    <option selected>Выбрать страну</option>
                                    @forelse($countries as $item)
                                        <option value="{{$item->country_id}}" {{Auth::user()->country_id==$item->country_id ? "selected" :''}}>{{$item->title}}</option>
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
                            <div class="col-xs-12">
                                <label for="country" class="col-form-label">Область(Штат)</label>
                                <select class="form-control" id="region" name="region">
                                    <option selected>Выбрать</option>
                                    @forelse($regions as $item)
                                        <option value="{{$item->region_id}}" {{Auth::user()->region_id==$item->region_id ? 'selected' :''}}>{{$item->title}}</option>
                                    @empty
                                        <option selected>Нет областей</option>
                                    @endforelse
                                </select>
                                @if ($errors->has('region'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('region') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}" id="citySelect">
                            <div class="col-xs-12">
                                <label for="country" class="col-form-label">Город</label>
                                <select class="form-control" id="city" name="city">
                                    <option>Выбрать</option>
                                    @forelse($cities as $item)
                                        <option value="{{$item->city_id}}" {{Auth::user()->city_id==$item->city_id ? 'selected' :''}}>{{$item->title}}</option>
                                    @empty
                                        <option selected>Нет городов</option>
                                    @endforelse
                                </select>
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date_birth') ? ' has-danger' : '' }}">
                            <div class="col-xs-12">
                                <label for="date_birth" class="col-form-label">Дата рождения*</label>
                                <input class="form-control date_birth" type="date" value="{{$user->date_birth}}" id="date_birth"
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
                                <button type="submit" class="btn btn-success">
                                    Сохранить
                                </button>
                                <div class="small-space"></div>
                            </div>
                            <div class="col-md-6 text-right text-center-sm text-center-xs">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')


    <script>
        $(document).ready(function () {

        $('.date_birth').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        var countryId = null;
        var regionId = null;
        $("#country").change(function () {
            countryId = $(this).val();
            $.getJSON("{{url('api/actualRegions')}}/" + $(this).val(), function (jsonData) {
                select = '';
                // select += '<option selected> Выбрать</option>';
                $.each(jsonData, function (i, data) {
                    select += '<option value="' + data.region_id + '">' + data.title + '</option>';
                });
                select += '';

                $("#region").html(select);
                if (select.length == 0) {
                    //$("#region").change();
                    $.getJSON("{{url('api/actualCities')}}/" + countryId, function (jsonData) {

                        select = '';
                        $.each(jsonData, function (i, data) {
                            select += '<option value="' + data.city_id + '">' + data.title + '</option>';
                        });
                        select += '';
                        $("#city").html(select);
                    });

                    // alert("true");
                }
                else {
                    $("#city").html('');
                    $("#region").change();
                }
                ;
            });


        });
        $("#region").change(function () {
            regionId = $(this).val();
            countryId = $("#country").val();

            $.getJSON("{{url('api/actualCities')}}/" + countryId + "?region_id=" + regionId, function (jsonData) {

                select = '';
                $.each(jsonData, function (i, data) {
                    select += '<option value="' + data.city_id + '">' + data.title + '</option>';
                });
                select += '';
                $("#city").html(select);
            });
        });

        });
    </script>
@stop