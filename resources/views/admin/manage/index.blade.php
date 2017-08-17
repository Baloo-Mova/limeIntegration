@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Выбор пользователей <!--<span class="participants_count"></span>-->
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-body">
                    <span class="add_form_button" data-current-id="1">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                    </span>
                        <form action="" method="post" class="manage_form">
                            <div class="col-md-4 ">
                            <div class="root_wrap">
                                <div class="row" data-current-id="1">
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
                                                <option value="" selected disabled>Выберите регион</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 city_wrap_1">
                                        <div class="form-group">
                                            <label for="exampleTextarea">Город</label>
                                            <select name="city_1" id="" class="form-control city_select city_select_1" data-current-id="1">
                                                <option value="" selected disabled>Выберите город</option>
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
                                                @forelse($worksheets as $worksheet)
                                                    <option value="{{ $worksheet->sid }}">
                                                        {{ $worksheet->limeSurveysLanguage->first()->surveyls_title }}
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
                            </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary count_button">Найти</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="results_counter">Найдено: 0</p>
                                <div class="results_wrap">

                                </div>
                            </div>
                        </form>

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
                                        <option value="{{ $survey->sid }}" >{{ $survey->LimeSurveysLanguage->first()->surveyls_title }}</option>
                                    @empty
                                        <option value="" disabled>Опросов нет</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="participants_wrap">

                            </div>
                            <button type="submit" class="btn btn-success">Добавить пользователей к опросу</button>
                        </form>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-body">
                        <form action="{{ route('admin.send.base.messages.list') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="survey" class="control-label">Сообщение</label>
                                <textarea name="text" id="" class="form-control"></textarea>
                            </div>
                            <div class="users_wrap">

                            </div>
                            <button type="submit" class="btn btn-success">Написать пользователям</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $(".questions_wrap_1").hide();
            $(".answer_condition_1").hide();
            $(".type_wrap_1").hide();
            $(".country_wrap_1").hide();
            $(".region_wrap_1").hide();
            $(".city_wrap_1").hide();
            $(".age_wrap_1").hide();
            $(".gender_wrap_1").hide();

            $(".count_button").on("click", function(e){
                e.preventDefault();
               var form = $(".manage_form").serialize(),
                   count = $(".add_form_button").data("currentId");
                $.ajax({
                    method  : "post",
                    url     : "{{ route('get.list.participants') }}",
                    data    : {data : form, count : count},
                    success : function (data) {
                        console.log(data);

                        $(".results_counter").text("Найдено: "+data.length+ " участников");
                        var questions_str = '<ul class="results_ul">',
                            participants_str = '';
                        data.forEach(function (item, i, arr) {
                            questions_str += '<li class="results_li"><a href="{{ url("/admin/users/show-by-pid") }}/'+item.participant_id+'">'+item.firstname+' '+item.lastname+'</a></li>';
                            participants_str += '<input type="hidden" name="participant['+i+']" value="'+item.participant_id+'">';
                        });
                        questions_str += '</ul>';

                        $(".participants_wrap").html(participants_str);
                        $(".results_wrap").html(questions_str);
                        $(".users_wrap").html(participants_str);


                    },
                    dataType: "json"
                });
            });

            $(".add_form_button").on("click", function () {
                var current_id = $(this).data("currentId"),
                    new_id = current_id + 1;
                $(this).data("currentId", new_id);
                $(this).attr("data-current-id", new_id);

                $(".root_wrap").append('<div class="row" data-current-id="'+new_id+'">'+
                        '<div class="text-center"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>'+
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
                '@forelse($worksheets as $worksheet)'+
                '<option value="{{ $worksheet->sid }}">'+
                        '{{ $worksheet->limeSurveysLanguage->first()->surveyls_title }}'+
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
                    '</div>');

                $(".questions_wrap_"+new_id).hide();
                $(".answer_condition_"+new_id).hide();
                $(".type_wrap_"+new_id).hide();
                $(".country_wrap_"+new_id).hide();
                $(".region_wrap_"+new_id).hide();
                $(".city_wrap_"+new_id).hide();
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