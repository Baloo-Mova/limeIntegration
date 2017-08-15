@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Обработка анкет
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Выгрузка new</h4>
                        <div class="grid-view">
                            <form action="{{ route('admin.surveys.processing.finished.worksheets') }}" method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12 export_type_wrap">
                                        <div class="form-group">
                                            <label for="export_type">Выборка по</label>
                                            <select name="export_type" class="form-control export_type" id="export_type">
                                                <option disabled selected>Выберите вариант</option>
                                                <option value="1">Пользователь</option>
                                                <option value="2">Анкета</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 users_wrap">
                                        <div class="form-group">
                                            <label for="user_select">Пользователи</label><br>
                                            <select name="user" class="user_select" id="user_select">
                                                <option disabled selected>Выберите вариант</option>
                                                @forelse($users as $user)
                                                    <option value="{{ $user->participant_id }}">{{ $user->firstname." ".$user->lastname }}</option>
                                                @empty
                                                    <option disabled selected>Нет пользователей</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 surveys_wrap">
                                        <div class="form-group">
                                            <label for="surveys">Анкеты</label><br>
                                            <select name="surveys" class="surveys" id="surveys">
                                                <option disabled selected>Выберите вариант</option>
                                                @forelse($surveys as $survey)
                                                    <option value="{{ $survey->sid }}">{{ $survey->LimeSurveysLanguage->first()->surveyls_title }}</option>
                                                @empty
                                                    <option disabled selected>Нет пользователей</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 type_survey_wrap">
                                        <div class="form-group">
                                            <label for="type_survey">Тип анкеты</label>
                                            <select name="type_survey" class="form-control type_survey" id="type_survey">
                                                <option disabled selected>Выберите вариант</option>
                                                <option value="1">Выгрузка пройденных анкет</option>
                                                <option value="2">Выгрузка не пройденных анкет</option>
                                                <option value="3">Выгрузка всех анкет</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="user">Период времени</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </span>
                                                <input type="text" name="date" class="form-control finished_worsheets" id="" aria-describedby=""
                                                       value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="submit">Выгрузить</button>
                                    </div>
                                </div>
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
        $(document).ready(function() {
            $('.finished_worsheets').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY.MM.DD'
                }
            });

            $('.finished_worsheets').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('.finished_worsheets').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $(".users_wrap").hide();
            $(".surveys_wrap").hide();
            $(".type_survey_wrap").hide();

            $(".user_select").select2();
            $(".surveys").select2();

            $(".export_type").on("change", function () {
                var type = $(this).val();

                if(type == 1){
                    $(".users_wrap").show();
                    $(".surveys_wrap").hide();
                }else{
                    $(".surveys_wrap").show();
                    $(".users_wrap").hide();
                    $(".type_survey_wrap").hide();
                }
            });

            $(".user_select").on("change", function () {
                $(".type_survey_wrap").show();
            });

        });
    </script>
@stop