@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Выбор пользователей <span class="participants_count"></span>
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <span class="add_form_button">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                    </span>
                        <form action="" method="post" class="manage_form">
                            <div class="col-md-4 root_wrap">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleTextarea">Анкеты</label>
                                            <select name="type" id="" class="form-control type_select">
                                                <option value="" selected disabled>Выберите тип</option>
                                                @forelse($surveys as $survey)
                                                    <option value="{{ $survey->sid }}">
                                                        {{ $survey->limeSurveysLanguage->first()->surveyls_title }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>Анкет нет</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 questions_wrap">
                                        <div class="form-group">
                                            <label for="exampleTextarea">Условие</label>
                                            <select name="question_condition" id="" class="form-control question_condition">
                                                <option value=""></option>
                                                <option value="">Да</option>
                                                <option value="">Нет</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 questions_wrap">
                                        <div class="form-group">
                                            <label for="exampleTextarea">Вопросы</label>
                                            <select name="questions" id="" class="form-control questions_select" data-sid="">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 answer_condition">
                                        <div class="form-group">
                                            <label for="exampleTextarea">Ответы</label>
                                            <select name="answers" id="" class="form-control answers_select" data-sid="" data-gid="" data-qid="">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Выбрать</button>
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
        $(document).ready(function () {
            $(".questions_wrap").hide();
            $(".answer_condition").hide();

            $(".add_form_button").on("click", function () {
                $(".root_wrap").append('<hr><div class="row">' +
                        '<div class="col-md-12">' +
                '<div class="form-group">' +
                    '<label for="exampleTextarea">Анкеты</label>' +
                    '<select name="type" id="" class="form-control type_select">' +
                    '<option value="" selected disabled>Выберите тип</option>' +
                        '@forelse($surveys as $survey)' +
                    '<option value="{{ $survey->sid }}">' +
                    '{{ $survey->limeSurveysLanguage->first()->surveyls_title }}' +
                    '</option>' +
                    '@empty' +
                    '<option value="" disabled>Анкет нет</option>' +
                    '@endforelse' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-12 questions_wrap">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Условие</label>'+
                    '<select name="question_condition" id="" class="form-control question_condition">'+
                    '<option value=""></option>'+
                    '<option value="">Да</option>'+
                    '<option value="">Нет</option>'+
                    '</select>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-12 questions_wrap">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Вопросы</label>'+
                    '<select name="questions" id="" class="form-control questions_select" data-sid="">'+
                    '</select>'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-md-12 answer_condition">'+
                    '<div class="form-group">'+
                    '<label for="exampleTextarea">Ответы</label>'+
                    '<select name="answers" id="" class="form-control answers_select" data-sid="" data-gid="" data-qid="">'+
                    '</select>'+
                    '</div>'+
                    '</div>'+
                    '</div>');
            });



            $(".type_select").on("change", function(){
                $(".questions_wrap").show();
                $(".answer_condition").hide();
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
                            $(".questions_select").html(questions_str);
                            $(".questions_select").data('sid', sid);
                            $(".questions_select").attr('sid', sid);
                        }
                    },
                    dataType: "json"
                });

            });

            $(".questions_select").on("change", function(){
                $(".answer_condition").show();
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
                            $(".answers_select").html(questions_str);
                            $(".answers_select").data('sid', sid);
                            $(".answers_select").attr('sid', sid);
                            $(".answers_select").data('qid', qid);
                            $(".answers_select").attr('qid', qid);
                            $(".answers_select").data('gid', data.gid);
                            $(".answers_select").attr('gid', data.gid);
                        }
                    },
                    dataType: "json"
                });

            });

            $(".answers_select").on("change", function(){
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
                           $(".participants_count").text("Найдено "+data.length+" участников");
                        }
                    },
                    dataType: "json"
                });

            });

        });
    </script>
@stop