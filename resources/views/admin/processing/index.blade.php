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
                                    <div class="col-md-12 users_wrap">
                                        <div class="form-group">
                                            <label for="user_select">Пользователи</label><br>
                                            <select name="user" class="user_select" id="user_select">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 type_survey_wrap">
                                        <div class="form-group">
                                            <label for="type_survey">Тип анкеты</label>
                                            <select name="type_survey" class="form-control type_survey"
                                                    id="type_survey">
                                                <option value="0">Выбор в ручную</option>
                                                <option value="1">Выгрузка пройденных анкет</option>
                                                <option value="2">Выгрузка не пройденных анкет</option>
                                                <option value="3" selected>Выгрузка всех анкет</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 surveys_wrap">
                                        <div class="form-group">
                                            <label for="surveys">Анкеты</label><br>
                                            <select name="surveys[]" class="surveys" id="surveys" multiple>
                                                @forelse($surveys as $survey)
                                                    <option value="{{ $survey->sid }}">{{ $survey->LimeSurveysLanguage->surveyls_title }}</option>
                                                @empty
                                                    <option disabled selected>Нет пользователей</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    {{--<div class="col-md-12">--}}
                                    {{--<div class="form-group">--}}
                                    {{--<label for="user">Период времени</label>--}}
                                    {{--<div class="input-group">--}}
                                    {{--<span class="input-group-addon">--}}
                                    {{--<i class="fa fa-calendar" aria-hidden="true"></i>--}}
                                    {{--</span>--}}
                                    {{--<input type="text" name="date" class="form-control finished_worsheets"--}}
                                    {{--id="" aria-describedby=""--}}
                                    {{--value="">--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
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

@section('css')
    <style>
        .select2-container .select2-selection--single {
            height: 34px;
            border-radius: 0px;
            border-color: #d2d6de;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            var surveys = $(".surveys").select2({
                placeholder: "Select Survey"
            });
            $('.finished_worsheets').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY.MM.DD'
                }
            });

            $('.finished_worsheets').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('.finished_worsheets').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            $(".surveys_wrap").hide();
            $(".type_survey_wrap").hide();

            var userselect = $(".user_select").select2({
                allowClear: true,
                placeholder: "Search for a user",
                minimumInputLength: 3,
                ajax: {
                    url: "{{route('admin.get.users')}}",
                    dataType: 'json',
                    delay: 500,
                    data: function (term, page) { // page is the one-based page number tracked by Select2
                        return {
                            email: term,
                            page: page // page number
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data,
                            pagination: {
                                more: data.length == 10
                            }
                        };
                    },
                },
            });

            userselect.on('select2:select', function (data) {
                $(".type_survey_wrap").show();
            });

            $("#type_survey").on('change', function () {
                if ($(this).val() == 0) {
                    $(".surveys_wrap").show();
                } else {
                    $(".surveys_wrap").hide();
                }
            });

            userselect.on('select2:unselect', function (data) {
                $(".type_survey_wrap").hide();
                surveys.val(null).trigger('change');
            });
        })
        ;
    </script>
@stop