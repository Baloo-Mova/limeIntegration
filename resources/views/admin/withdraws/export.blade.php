@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-money'></i>  Админ. Экспорт заявок на вывод средств.
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-md-4 users_wrap">
                        <form action="{{ route('admin.withdraws.export.csv') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="user_select">Пользователи</label><br>
                                <select name="user" class="user_select" id="user_select">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="user">Период времени</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </span>
                                        <input type="text" name="date" class="form-control finished_worsheets"
                                        id="" aria-describedby=""
                                        value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="send_all" class="col-form-label">Экспортировать все заявки</label><br>
                                <input type="checkbox" name="send_all" class="send_all" id="send_all">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Экспортировать</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $(".send_all").bootstrapSwitch();
            $('.send_all').on('switchChange.bootstrapSwitch', function(event, state) {
                if(state){
                    $(".finished_worsheets").attr("disabled", true);
                    $(".user_select").attr("disabled", true);
                }else{
                    $(".finished_worsheets").attr("disabled", false);
                    $(".user_select").attr("disabled", false);
                }
            });
            $('.finished_worsheets').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY.MM.DD'
                }
            });

            $('.finished_worsheets').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM-DD-YYYY') + ' - ' + picker.endDate.format('MM-DD-YYYY'));
            });

            $('.finished_worsheets').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
            var userselect = $(".user_select").select2({
                allowClear: true,
                placeholder: "Search for a user",
                minimumInputLength: 3,
                ajax: {
                    url: "{{route('admin.get.users.by.name')}}",
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
        });
    </script>
@stop