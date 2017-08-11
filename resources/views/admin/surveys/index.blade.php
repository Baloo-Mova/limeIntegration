@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Все опросы
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <!--<div>
                        <a href="{{ route('admin.paymentstypes.create') }}" class="btn btn-success center">Создать</a>
                    </div>-->

                    <hr/>


                    <div class="grid-view">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th><a class="" href="#">Название</a></th>
                                <th><a class="" href="#">Вознаграждение</a></th>
                                <th><a class="" href="#">Статус</a></th>
                                <th><a class="" href="#">Тип</a></th>
                                <th>Действия</th>
                            </tr>

                            </thead>
                            <tbody class='text-center'>
                                @forelse($surveys as $survey)
                                    <tr>
                                        <td>{{ $survey->sid }}</td>
                                        <td>{{ $survey->LimeSurveysLanguage->first()->surveyls_title }}</td>
                                        <td>{{ $survey->reward }} ₽</td>
                                        <td>{{ ($survey->active == 'Y' ? 'Активен' : 'Не активен') }}</td>
                                        <td>{{ ($survey->type_id == 0 ? 'Анкета' : 'Опрос') }}</td>
                                        <td>
                                            @if($survey->type_id == 1)
                                                <a href="{{route('admin.surveys.convertToWorksheet', ['sid' => $survey->sid, 'type' => 0])}}" title="Сделать анкетой"
                                                   aria-label="Update"
                                                   data-pjax="0">
                                                    <span class="fa fa-id-card"></span>
                                                </a>
                                            @else
                                                <div id="myModalBox" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form id="update_form" action="{{ route('admin.surveys.change.rewards') }}" method="POST">
                                                            <!-- Заголовок модального окна -->
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title">Изменение вознаграждения</h4>
                                                            </div>
                                                            <!-- Основное содержимое модального окна -->
                                                            <div class="modal-body">

                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="sid" class="sid">
                                                                    <div class="form-group">
                                                                        <label for="exampleTextarea">Вознаграждение</label>
                                                                        <input type="text" name="money" class="form-control money">
                                                                    </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                                                    <button type="submit" class="btn btn-primary">Сохранить</button>

                                                                </div>
                                                            </div>
                                                            <!-- Футер модального окна -->

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="{{route('admin.surveys.convertToWorksheet', ['sid' => $survey->sid, 'type' => 1])}}" title="Сделать опросом"
                                                   aria-label="Update"
                                                   data-pjax="0">
                                                    <span class="fa fa-list-ul"></span>
                                                </a>

                                            @endif
                                                <a href="#myModalBox" class="call_modal"  data-toggle="modal" title="Изменить вознаграждение" data-money="{{ $survey->reward }}" data-sid="{{ $survey->sid }}"><span class="fa fa-money"> </span></a>
                                        </td>
                                    </tr>
                                @empty
                                    <td class="text-center" colspan="6">
                                        <p>Опросов не найдено</p>
                                    </td>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $(".modal").modal('hide');
            $(".call_modal").on("click", function () {
                var money = $(this).data("money"),
                    sid = $(this).data("sid");

                $(".money").val(money);
                $(".sid").val(sid);
            });
        });
    </script>
@stop