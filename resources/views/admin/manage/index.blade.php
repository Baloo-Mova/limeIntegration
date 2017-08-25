@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Добавление пользователей к опросу<!--<span class="participants_count"></span>-->
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <span class="add_form_button" data-current-id="{{ isset($forms_count) ? $forms_count : "1" }}">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                                </span>
                                <form action="" method="post" class="manage_form" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="count" class="count_parameters" value="{{ isset($forms_count) ? $forms_count : "1" }}">
                                    <div class="root_wrap">
                                        @if(isset($forms))
                                            @foreach($forms as $key=>$form)
                                                <?php $key++; ?>
                                                <div class="col-md-4" data-current-id="{{ $key }}">
                                                        <div class="col-md-12" >
                                                            <div class="form-group">
                                                                <label for="exampleTextarea">Тип поиска</label>
                                                                <select name="type_search_{{ $key }}" id="" class="form-control type_search_select type_search_select_{{ $key }}" data-current-id="1">
                                                                    <option value="" disabled>Выберите тип</option>
                                                                    <option value="1" {{ $form['type_search'] == 1 ? "selected" : ""}}>Данные профиля</option>
                                                                    <option value="2" {{ $form['type_search'] == 2 ? "selected" : ""}}>Данные анкет</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 country_wrap_{{ $key }}" {{ isset($form['country']) ? "data-hidden=0" : "data-hidden=1" }}>
                                                            <div class="form-group">
                                                                <label for="exampleTextarea">Страна</label>
                                                                <select name="country_{{ $key }}" id="" class="form-control country_select country_select_{{ $key }}" data-current-id="{{ $key }}">
                                                                    <option value="" {{ isset($form['country']) ? "" : "selected" }} disabled>Выберите страну</option>
                                                                    @forelse($countries as $item)
                                                                        <option value="{{$item->country_id}}" {{ isset($form['country']) && $form['country'] == $item->country_id ? "selected" : ""}}>{{$item->title}}</option>
                                                                    @empty
                                                                        <option selected>Нет стран</option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 region_wrap_{{ $key }}" {{ isset($form['region']) ? "data-hidden=0" : "data-hidden=1" }}>
                                                            <div class="form-group">
                                                                <label for="exampleTextarea">Регион</label>
                                                                <select name="region_{{ $key }}" id="" class="form-control region_select region_select_{{ $key }}" data-current-id="{{ $key }}">
                                                                    <option value="" {{ isset($form['region']) ? "" : "selected" }} disabled>Выберите регион</option>
                                                                    @if(isset($form['region']))
                                                                        @forelse($form['region_select'] as $region)
                                                                            <option value="{{$region->region_id}}" {{ isset($form['region']) && $form['region'] == $region->region_id ? "selected" : ""}}>{{$region->title}}</option>
                                                                        @empty
                                                                            <option selected>Нет регионов</option>
                                                                        @endforelse
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 city_wrap_{{ $key }}" {{ isset($form['city']) ? "data-hidden=0" : "data-hidden=1" }}>
                                                            <div class="form-group">
                                                                <label for="exampleTextarea">Город</label>
                                                                <select name="city_{{ $key }}" id="" class="form-control city_select city_select_{{ $key }}" data-current-id="{{ $key }}">
                                                                    <option value="" {{ isset($form['city']) ? "" : "selected" }} disabled>Выберите город</option>
                                                                    @if(isset($form['city']))
                                                                        @forelse($form['city_select'] as $city)
                                                                            <option value="{{$city->city_id}}" {{ isset($form['city']) && $form['city'] == $city->city_id ? "selected" : ""}}>{{$city->title}}</option>
                                                                        @empty
                                                                            <option selected>Нет городов</option>
                                                                        @endforelse
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 gender_wrap_{{ $key }}" {{ isset($form['gender']) ? "data-hidden=0" : "data-hidden=1" }}>
                                                            <div class="form-group">
                                                                <label for="exampleTextarea">Пол</label>
                                                                <select name="gender_{{ $key }}" id="" class="form-control gender_select gender_select_{{ $key }}" data-current-id="{{ $key }}">
                                                                    <option value="" {{ isset($form['gender']) ? "" : "selected" }} disabled>Выберите пол</option>
                                                                    <option value="0" {{ isset($form['gender']) && $form['gender'] == 0 ? "selected" : ""}}>Мужской</option>
                                                                    <option value="1" {{ isset($form['gender']) && $form['gender'] == 1 ? "selected" : ""}}>Женский</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 age_wrap_{{ $key }}" {{ isset($form['age_from']) ? "data-hidden=0" : "data-hidden=1" }}>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label for="exampleTextarea">Возраст</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="exampleTextarea">от
                                                                        </label>
                                                                        <input type="number" value="{{ isset($form['age_from']) ? $form['age_from'] : "" }}" name="age_from_{{ $key }}" class="form-control age_from age_from_{{ $key }}" data-current-id="{{ $key }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="exampleTextarea">до</label>
                                                                        <input type="number" value="{{ isset($form['age_to']) ? $form['age_to'] : "" }}" name="age_to_{{ $key }}" class="form-control age_to age_to_{{ $key }}" data-current-id="{{ $key }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 type_wrap_{{ $key }}" {{ isset($form['type']) ? "data-hidden=0" : "data-hidden=1" }}>
                                                            <div class="form-group">
                                                                <label for="exampleTextarea">Анкеты</label>
                                                                <select name="type_{{ $key }}" id="" class="form-control type_select type_select_{{ $key }}" data-current-id="{{ $key }}">
                                                                    <option value="" {{ isset($form['type']) ? "" : "selected" }} disabled>Выберите анкету</option>
                                                                    @forelse($surveys as $worksheet)
                                                                        @if($worksheet->type_id == 1)
                                                                            @continue
                                                                        @endif
                                                                        <option value="{{ $worksheet->sid }}" {{ isset($form['type']) && $form['type'] == $worksheet->sid ? "selected" : ""}}>
                                                                            {{ $worksheet->limeSurveysLanguage->surveyls_title }}
                                                                        </option>
                                                                    @empty
                                                                        <option value="" disabled>Анкет нет</option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 questions_wrap_{{ $key }}" {{ isset($form['questions']) ? "data-hidden=0" : "data-hidden=1" }}>
                                                            <div class="form-group">
                                                                <label for="exampleTextarea">Вопросы</label>
                                                                <select name="questions_{{ $key }}" id="" class="form-control questions_select questions_select_{{ $key }}" data-sid="" data-current-id="{{ $key }}">
                                                                    <option value="" {{ isset($form['questions']) ? "" : "selected" }} disabled>Выберите вопрос</option>
                                                                    @if(isset($form['questions']))
                                                                        @forelse($form['questions_select'] as $question)
                                                                            <option value="{{$question->qid}}" {{ isset($form['questions']) && $form['questions'] == $question->qid ? "selected" : ""}}>{{$question->question}}</option>
                                                                        @empty
                                                                            <option selected>Нет вопросов</option>
                                                                        @endforelse
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="gid_{{ $key }}" class="gid_{{ $key }}" value="{{ isset($form['gid']) ? $form['gid'] : "" }}">
                                                        <div class="col-md-12 answer_condition_{{ $key }}" {{ isset($form['answers']) ? "data-hidden=0" : "data-hidden=1" }}>
                                                            <div class="form-group">
                                                                <label for="exampleTextarea">Ответы</label>
                                                                <select name="answers_{{ $key }}" id="" class="form-control answers_select answers_select_{{ $key }}" data-sid="" data-gid="" data-qid="" data-current-id="{{ $key }}">
                                                                    <option value="" {{ isset($form['answers']) ? "" : "selected" }} disabled>Выберите город</option>
                                                                    @if(isset($form['answers']))
                                                                        @forelse($form['answers_select'] as $answer)
                                                                            <option value="{{$answer->code}}" {{ isset($form['answers']) && $form['answers'] == $answer->code ? "selected" : ""}}>{{$answer->answer}}</option>
                                                                        @empty
                                                                            <option selected>Нет вопросов</option>
                                                                        @endforelse
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-4" data-current-id="1">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Тип поиска</label>
                                                            <select name="type_search_1" id="" class="form-control type_search_select type_search_select_1" data-current-id="1">
                                                                <option value="" selected disabled>Выберите тип</option>
                                                                <option value="1">Данные профиля</option>
                                                                <option value="2">Данные анкет</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 country_wrap_1">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Страна</label>
                                                            <select name="country_1" id="" class="form-control country_select country_select_1" data-current-id="1">
                                                                <option value="" selected disabled>Выберите страну</option>
                                                                @forelse($countries as $item)
                                                                    <option value="{{$item->country_id}}">{{$item->title}}</option>
                                                                @empty
                                                                    <option selected>Нет стран</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 region_wrap_1">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Регион</label>
                                                            <select name="region_1" id="" class="form-control region_select region_select_1" data-current-id="1">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 city_wrap_1">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Город</label>
                                                            <select name="city_1" id="" class="form-control city_select city_select_1" data-current-id="1">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 gender_wrap_1">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Пол</label>
                                                            <select name="gender_1" id="" class="form-control gender_select gender_select_1" data-current-id="1">
                                                                <option value="" selected disabled>Выберите пол</option>
                                                                <option value="0">Мужской</option>
                                                                <option value="1">Женский</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 age_wrap_1">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="exampleTextarea">Возраст</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="exampleTextarea">от
                                                                    </label>
                                                                    <input type="number" name="age_from_1" class="form-control age_from age_from_1" data-current-id="1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="exampleTextarea">до</label>
                                                                    <input type="number" name="age_to_1" class="form-control age_to age_to_1" data-current-id="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 type_wrap_1">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Анкеты</label>
                                                            <select name="type_1" id="" class="form-control type_select type_select_1" data-current-id="1">
                                                                <option value="" selected disabled>Выберите анкету</option>
                                                                @forelse($surveys as $worksheet)
                                                                    @if($worksheet->type_id == 1)
                                                                        @continue
                                                                    @endif
                                                                    <option value="{{ $worksheet->sid }}" >
                                                                        {{ $worksheet->limeSurveysLanguage->surveyls_title }}
                                                                    </option>
                                                                @empty
                                                                    <option value="" disabled>Анкет нет</option>
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 questions_wrap_1">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Вопросы</label>
                                                            <select name="questions_1" id="" class="form-control questions_select questions_select_1" data-sid="" data-current-id="1">

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="gid_1" class="gid_1">
                                                    <div class="col-md-12 answer_condition_1">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Ответы</label>
                                                            <select name="answers_1" id="" class="form-control answers_select answers_select_1" data-sid="" data-gid="" data-qid="" data-current-id="1">
                                                            </select>
                                                        </div>
                                                    </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary count_button">Найти</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <form action="{{ route('admin.manage.addListParticipant') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="survey" class="control-label">Опрос</label>
                                <select name="survey" id="" class="form-control">
                                    <option value="" disabled selected>Выберите опрос</option>
                                    @forelse($surveys as $survey)
                                        @if($survey->type_id == 0)
                                            @continue
                                        @endif
                                        <option value="{{ $survey->sid }}" >{{ $survey->LimeSurveysLanguage->surveyls_title }}</option>
                                    @empty
                                        <option value="" disabled>Опросов нет</option>
                                    @endforelse
                                </select>
                            </div>
                            <input type="hidden" name="guid" value="{{ isset($guid) ? $guid : '' }}">
                            <button type="submit" class="btn btn-success">Добавить пользователей к опросу</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            @if(isset($users))
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <p>
                                    Найдено: {{ $users_count }} {{ $users_count == 1 ? "пользователь" : ""}}
                                    {{ ($users_count > 1 && $users_count < 5 && $users_count != 1 ) ? "пользователя" : ""}}
                                    {{ ($users_count == 0 || $users_count > 4 ) ? "пользователей" : ""}}
                                </p>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Имя</th>
                                            <th>Фамилия</th>
                                            <th>Participant-id</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $u)
                                            <tr>
                                                <td><a href="{{ route('admin.users.show.pid', ['pid' => $u->participant_id]) }}">{{ $u->firstname }}</a></td>
                                                <td><a href="{{ route('admin.users.show.pid', ['pid' => $u->participant_id]) }}">{{ $u->lastname }}</a></td>
                                                <td><a href="{{ route('admin.users.show.pid', ['pid' => $u->participant_id]) }}">{{ $u->participant_id }}</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $users->appends(['scgid' => $guid, 'forms_count' => $forms_count])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {

            var cid = $(".add_form_button").data("currentId");

            for(i = 1; i <= cid; i++){
                var tmp = $(".questions_wrap_"+i).data("hidden");
                if(tmp == undefined){
                    $(".questions_wrap_"+i).hide();
                }else{
                    if(tmp == 1){
                        $(".questions_wrap_"+i).hide();
                    }
                }

                tmp = $(".answer_condition_"+i).data("hidden");
                if(tmp == undefined){
                    $(".answer_condition_"+i).hide();
                }else{
                    if(tmp == 1){
                        $(".answer_condition_"+i).hide();
                    }
                }

                tmp = $(".type_wrap_"+i).data("hidden");
                if(tmp == undefined){
                    $(".type_wrap_"+i).hide();
                }else{
                    if(tmp == 1){
                        $(".type_wrap_"+i).hide();
                    }
                }

                tmp = $(".country_wrap_"+i).data("hidden");
                if(tmp === undefined){

                    $(".country_wrap_"+i).hide();
                }else{
                    if(tmp == 1){
                        $(".country_wrap_"+i).hide();
                    }
                }

                tmp = $(".region_wrap_"+i).data("hidden");
                if(tmp == undefined){
                    $(".region_wrap_"+i).hide();
                }else{
                    if(tmp == 1){
                        $(".region_wrap_"+i).hide();
                    }
                }

                tmp = $(".city_wrap_"+i).data("hidden");
                if(tmp == undefined){
                    $(".city_wrap_"+i).hide();
                }else{
                    if(tmp == 1){
                        $(".city_wrap_"+i).hide();
                    }
                }

                tmp = $(".age_wrap_"+i).data("hidden");
                if(tmp == undefined){
                    $(".age_wrap_"+i).hide();
                }else{
                    tmp = $(".type_search_select_"+i).val();
                    if(tmp == 2){
                        $(".age_wrap_"+i).hide();
                    }
                }

                tmp = $(".gender_wrap_"+i).data("hidden");
                if(tmp == undefined){
                    $(".gender_wrap_"+i).hide();
                }else{
                    tmp = $(".type_search_select_"+i).val();
                    if(tmp == 2){
                        $(".gender_wrap_"+i).hide();
                    }
                }
            }

            $(".add_form_button").on("click", function () {
                var current_id = $(this).data("currentId"),
                    new_id = current_id + 1,
                    shift = "";
                $(".count_parameters").val(new_id);
                $(this).data("currentId", new_id);
                $(this).attr("data-current-id", new_id);

                if(new_id % 3 == 0){
                    shift = "<div class='col-md-12'></div>";
                }

                $(".root_wrap").append('<div class="col-md-4" data-current-id="'+new_id+'">'+
                        '<!--<div class="text-center"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>-->'+
                    '<div class="col-md-12">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Тип поиска</label>'+
                '<select name="type_search_'+new_id+'" id="" class="form-control type_search_select type_search_select_'+new_id+'" data-current-id="'+new_id+'">'+
                    '<option value="" selected disabled>Выберите тип</option>'+
                '<option value="1">Данные профиля</option>'+
                '<option value="2">Данные анкет</option>'+
                '</select>'+
                '</div>'+
                '</div>'+
                '<div class="col-md-12 country_wrap_'+new_id+'">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Страна</label>'+
                    '<select name="country_'+new_id+'" id="" class="form-control country_select country_select_'+new_id+'" data-current-id="'+new_id+'">'+
                    '<option value="" selected disabled>Выберите страну</option>'+
                '@forelse($countries as $item)'+
                '<option value="{{$item->country_id}}">{{$item->title}}</option>'+
                        '@empty'+
                    '<option selected>Нет стран</option>'+
                '@endforelse'+
                '</select>'+
                '</div>'+
                '</div>'+
                '<div class="col-md-12 region_wrap_'+new_id+'">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Регион</label>'+
                    '<select name="region_'+new_id+'" id="" class="form-control region_select region_select_'+new_id+'" data-current-id="'+new_id+'">'+
                    '<option value="" selected disabled>Выберите регион</option>'+
                '</select>'+
                '</div>'+
                '</div>'+
                '<div class="col-md-12 city_wrap_'+new_id+'">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Город</label>'+
                    '<select name="city_'+new_id+'" id="" class="form-control city_select city_select_'+new_id+'" data-current-id="'+new_id+'">'+
                    '<option value="" selected disabled>Выберите город</option>'+
                '</select>'+
                '</div>'+
                '</div>'+
                '<div class="col-md-12 gender_wrap_'+new_id+'">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Пол</label>'+
                    '<select name="gender_'+new_id+'" id="" class="form-control gender_select gender_select_'+new_id+'" data-current-id="'+new_id+'">'+
                    '<option value="" selected disabled>Выберите пол</option>'+
                '<option value="0">Мужской</option>'+
                    '<option value="1">Женский</option>'+
                    '</select>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-12 age_wrap_'+new_id+'">'+
                    '<div class="row">'+
                    '<div class="col-md-12">'+
                    '<label for="exampleTextarea">Возраст</label>'+
                    '</div>'+
                    '<div class="col-md-6">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">от'+
                    '</label>'+
                    '<input type="number" name="age_from_'+new_id+'" class="form-control age_from age_from_'+new_id+'" data-current-id="'+new_id+'">'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-6">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">до</label>'+
                    '<input type="number" name="age_to_'+new_id+'" class="form-control age_to age_to_'+new_id+'" data-current-id="'+new_id+'">'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-12 type_wrap_'+new_id+'">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Анкеты</label>'+
                    '<select name="type_'+new_id+'" id="" class="form-control type_select type_select_'+new_id+'" data-current-id="'+new_id+'">'+
                    '<option value="" selected disabled>Выберите анкету</option>'+
                '@forelse($surveys as $worksheet)'+
                '<option value="{{ $worksheet->sid }}">'+
                        '{{ $worksheet->limeSurveysLanguage->surveyls_title }}'+
                    '</option>'+
                        '@empty'+
                    '<option value="" disabled>Анкет нет</option>'+
                '@endforelse'+
                '</select>'+
                '</div>'+
                '</div>'+
                '<div class="col-md-12 questions_wrap_'+new_id+'">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Вопросы</label>'+
                    '<select name="questions_'+new_id+'" id="" class="form-control questions_select questions_select_'+new_id+'" data-sid="" data-current-id="'+new_id+'">'+

                    '</select>'+
                    '</div>'+
                    '</div>'+
                    '<input type="hidden" name="gid_'+new_id+'" class="gid_'+new_id+'">'+
                    '<div class="col-md-12 answer_condition_'+new_id+'">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Ответы</label>'+
                    '<select name="answers_'+new_id+'" id="" class="form-control answers_select answers_select_'+new_id+'" data-sid="" data-gid="" data-qid="" data-current-id="'+new_id+'">'+

                    '</select>'+
                    '</div>'+
                    '</div></div>'+shift);

                $(".questions_wrap_"+new_id).hide();
                $(".answer_condition_"+new_id).hide();
                $(".type_wrap_"+new_id).hide();
                $(".country_wrap_"+new_id).hide();
                $(".region_wrap_"+new_id).hide();
                $(".city_wrap_"+new_id).hide();
                $(".age_wrap_"+new_id).hide();
                $(".gender_wrap_"+new_id).hide();
            });




            $("body").on("change", ".type_search_select", function(){
                var current_id = $(this).data("currentId"),
                    type = $(this).val();

                if(type == 1){
                    $(".country_wrap_"+current_id).show();

                    $(".age_wrap_"+current_id).show();
                    $(".gender_wrap_"+current_id).show();
                }else{
                    $(".type_wrap_"+current_id).show();
                    $(".country_wrap_"+current_id).hide();
                    $(".region_wrap_"+current_id).hide();
                    $(".city_wrap_"+current_id).hide();
                    $(".age_wrap_"+current_id).hide();
                    $(".gender_wrap_"+current_id).hide();
                }

            });

            $("body").on("change", ".country_select", function(){
                var current_id = $(this).data("currentId"),
                    countryId = $(this).val();

                $.getJSON("{{url('api/actualRegions')}}/" + $(this).val(), function (jsonData) {
                    select = '<option value="" disabled selected></option>';
                    $.each(jsonData, function (i, data) {
                        select += '<option value="' + data.region_id + '">' + data.title + '</option>';
                    });
                    select += '';

                    $(".region_select_"+current_id).html(select);

                        $.getJSON("{{url('api/actualCities')}}/" + countryId , function (jsonData) {

                            select = '';
                            $.each(jsonData, function (i, data) {
                                select += '<option value="' + data.city_id + '">' + data.title + '</option>';
                            });
                            select += '';
                        });
                });

                    $(".region_wrap_"+current_id).show();

            });

            $("body").on("change", ".region_select", function(){
                var current_id = $(this).data("currentId"),
                    regionId = $(this).val(),
                    countryId = $(".country_select_"+current_id).val();

                $.getJSON("{{url('api/actualCities')}}/" + countryId + "?region_id=" + regionId, function (jsonData) {
                    select = '<option value="" disabled selected></option>';
                    $.each(jsonData, function (i, data) {
                        select += '<option value="' + data.city_id + '">' + data.title + '</option>';
                    });
                    select += '';
                    $(".city_select_"+current_id).html(select);
                });

                $(".city_wrap_"+current_id).show();

            });

            $("body").on("change", ".city_select", function(){
                var current_id = $(this).data("currentId");
                $(".gender_wrap_"+current_id).show();
            });

            $("body").on("change", ".gender_select", function(){
                var current_id = $(this).data("currentId");
                $(".age_wrap_"+current_id).show();
            });


            $("body").on("change", ".type_select", function(){
                var current_id = $(this).data("currentId");
                $(".questions_wrap_"+current_id).show();
                $(".answer_condition_"+current_id).hide();
                var sid = $(this).val();

                $.ajax({
                    method  : "post",
                    url     : "{{ route('get.survey.questions') }}",
                    data    : {sid : sid},
                    success : function (data) {
                        if(data != "error"){
                            var questions_str = '<option value="" selected disabled>Выберите вопрос</option>';
                            data.forEach(function (item, i, arr) {
                                questions_str += '<option value="'+item.qid+'" >'+item.question+'</option>';
                            });
                            $(".questions_select_"+current_id).html(questions_str);
                            $(".questions_select_"+current_id).data('sid', sid);
                            $(".questions_select_"+current_id).attr('data-sid', sid);
                        }
                    },
                    dataType: "json"
                });

            });

            $("body").on("change", ".questions_select", function(){
                var current_id = $(this).data("currentId");
                $(".answer_condition_"+current_id).show();
                var qid = $(this).val(),
                    sid = $(this).data('sid');

                $.ajax({
                    method  : "post",
                    url     : "{{ route('get.survey.questions.answers') }}",
                    data    : {qid : qid},
                    success : function (data) {
                        if(data != "error"){
                            var questions_str = '<option value="" selected disabled>Выберите ответ</option>';
                            data.data.forEach(function (item, i, arr) {
                                questions_str += '<option value="'+item.code+'" >'+item.answer+'</option>';
                            });
                            $(".answers_select_"+current_id).html(questions_str);
                            $(".answers_select_"+current_id).data('sid', sid);
                            $(".answers_select_"+current_id).attr('data-sid', sid);
                            $(".answers_select_"+current_id).data('qid', qid);
                            $(".answers_select_"+current_id).attr('data-qid', qid);
                            $(".answers_select_"+current_id).data('gid', data.gid);
                            $(".answers_select_"+current_id).attr('data-gid', data.gid);
                            $(".gid_"+current_id).val(data.gid);
                        }
                    },
                    dataType: "json"
                });

            });

            $("body").on("change", ".answers_select", function(){
                var current_id = $(this).data("currentId");
                var aid = $(this).val(),
                    qid = $(this).data('qid'),
                    sid = $(this).data('sid'),
                    gid = $(this).data('gid');
                $.ajax({
                    method  : "post",
                    url     : "{{ route('get.survey.participants') }}",
                    data    : {aid : aid, qid : qid, sid : sid, gid : gid},
                    success : function (data) {
                        if(data != "error"){
                           //$(".participants_count").text("Найдено "+data.length+" участников");
                        }
                    },
                    dataType: "json"
                });

            });

        });
    </script>
@stop