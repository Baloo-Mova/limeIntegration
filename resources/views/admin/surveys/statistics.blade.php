@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Статистика опросов
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="box box-primary admin-surveys__box">
                    <div class="box-body">
                            <h4>Количество пройденых анкет</h4>
                        <div class="grid-view">
                            <h2>{{ $finished }}</h2>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="box box-primary admin-surveys__box">
                    <div class="box-body">
                        <h4>Количество не пройденных (начатых) анкет</h4>
                        <div class="grid-view">
                            <h2>{{ $not_finished }}</h2>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-12 col-lg-4">
                <div class="box box-primary admin-surveys__box">
                    <div class="box-body">
                        <h4>Количество всего назначенных на опрос респондентов</h4>
                        <div class="grid-view">
                            <label for="">Выберите опрос</label>
                            <select class="form-control survey_select">
                                <option disabled selected></option>
                                @forelse($surveys as $survey)
                                    <option value="{{ $survey->sid }}">{{ $survey->LimeSurveysLanguage->first()->surveyls_title }}</option>
                                @empty
                                    <option disabled>Нет опросов</option>
                                @endforelse
                            </select>
                            <h2 class="survey_user_count">&nbsp;</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="box box-primary admin-surveys__box">
                    <div class="box-body">
                        <h4>Квоты</h4>
                        <div class="grid-view">
                            <div class="col-xs-12 col-md-4 pl0 pr0">
                                <label for="">Выберите опрос</label>
                                <select class="form-control survey_select_quote">
                                        <option disabled selected></option>
                                    @forelse($surveys as $survey)
                                        <option value="{{ $survey->sid }}">{{ $survey->LimeSurveysLanguage->first()->surveyls_title }}</option>
                                    @empty
                                        <option disabled>Нет опросов</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 pl0 pr0">
                                <div class="quotes__wrap">
                                    &nbsp;
                                </div>
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
        $(document).ready(function() {
            $(".survey_select").on("change", function () {
                var survey_id = $(this).val();
                $.ajax({
                    method  : "get",
                    url     : "{{ url('api/get-count-participants') }}/" + survey_id,
                    success : function (data) {
                        if(data != "error"){
                            $(".survey_user_count").text(data);
                        }else{
                            $(".survey_user_count").html("<p>Нет респондентов</p>");
                        }
                    },
                    dataType: "json"
                });
            });
            $(".survey_select_quote").on("change", function () {
                var survey_id = $(this).val();
                $.ajax({
                    method  : "get",
                    url     : "{{ url('api/get-quotes') }}/" + survey_id,
                    success : function (data) {
                        if(data !== "error"){

                            var quotes_html = "<ul class='quotes_list_ul'>";
                            data.forEach(function(item, i, arr) {
                                quotes_html += "<li>"+item.name+"</li>"
                            });

                            $(".quotes__wrap").html(quotes_html+"</ul>");
                        }else{

                            $(".quotes__wrap").html("<p>Квот не найдено</p>");
                        }
                    },
                    dataType: "json"
                });
            });
        });
    </script>
@stop