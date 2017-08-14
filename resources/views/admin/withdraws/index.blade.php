@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-money'></i>  Админ. Заявки на вывод средств.
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <a href="{{ route('admin.withdraws.export') }}" class="btn btn-success">Экспорт</a>
                    <div class="h10" style="height: 10px;"></div>
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th class="table-header">
                                    <a href="">
                                        Пользователь</a>
                                </th>
                                <th class="table-header">
                                    <a href="">
                                        Назначение
                                    </a>
                                </th>
                                <th class="table-header">
                                    <a href="">
                                        Сумма
                                    </a>
                                </th>
                                <th class="table-header">
                                    <a href="">
                                        Тип
                                    </a>
                                </th>
                               <!-- <th class="table-header">Статус</th>-->
                                <th class="table-header">
                                    @if($column == "created_at" &&)
                                    <a href="{{ route('admin.withdraws.index', ['column' => 'created_at', 'direction' => 'desc']) }}">
                                        Дата Создания
                                    </a>
                                </th>
                                <th class="table-header"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($withdraws as $item)
                                <tr class="{{$item->getStatusColor()}}">
                                    <td><a href="{{route('admin.users.show',['id'=>$item->user->id])}}">{{$item->user->name." ".$item->user->second_name}}</a></td>
                                    <td>{{$item->destination}}</td>
                                    <td>{{$item->amount}} ₽</td>
                                    <td>{{$item->payment_type_id==0 ? \Illuminate\Support\Facades\Lang::get('messages.paymentstypeLocal') : $item->paymentstype->title}} </td>
                                    <!--<td>{{$item->getStatusMessage() }} </td>-->
                                    <td>{{$item->created_at}} </td>
                                    <td>
                                        @if($item->status==0)
                                        <a href="#" class="btn btn-success" onclick="document.getElementById('status').value = '1';document.getElementById('withdraw_id').value = '{{$item->id}}';event.preventDefault();document.getElementById('update_form').submit();" title="Подтвердить заявку" ><span class="fa fa-check"></span></a>
                                        <a href="#myModal" class="btn btn-danger" data-toggle="modal" onclick="document.getElementById('status').value = '2';document.getElementById('withdraw_id').value = '{{$item->id}}';document.getElementById('description').value = '{{isset($item->description)?$item->description : ''}}';" title="Отменить заявку"><span class="fa fa-close"> </span></a>
                                        @else
                                            <a href="#myModal2" class="btn btn-default" data-toggle="modal" onclick="document.getElementById('updated_at').value = '{{$item->updated_at}}';document.getElementById('description_view').value = '{{isset($item->description)?$item->description : 'no'}}';" title="Посмотреть дополнительные сведения"><span class="fa fa-tasks"> </span></a>

                                        @endif
                                        <a href="{{ route('admin.withdraws.delete', ['id'=>$item->id]) }}" class="btn btn-default"
                                           title="Удалить заявку" aria-label="Delete"
                                           data-confirm="Вы точно хотите удалить заявку?" data-method="post"
                                           data-pjax="0">
                                            <span class="fa fa-trash"></span>
                                        </a>

                                    </td>


                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {!! $withdraws->links() !!}

                    <div id="myModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Заголовок модального окна -->
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Укажите причину отмены</h4>
                                </div>
                                <!-- Основное содержимое модального окна -->
                                <div class="modal-body">
                                    <form id="update_form" action="{{ route('admin.withdraws.status.update') }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="number" name="status" id="status" hidden>
                                        <input type="number" name="withdraw_id" id="withdraw_id" hidden>
                                        <div class="form-group">
                                            <label for="exampleTextarea">Описание</label>
                                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                        </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                        <a href="#" class="btn btn-primary"onclick="document.getElementById('status').value = '2';event.preventDefault();document.getElementById('update_form').submit();" >Применить</a>

                                    </div>
                                </div>
                                <!-- Футер модального окна -->

                            </div>
                        </div>
                    </div>
                    <div id="myModal2" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Заголовок модального окна -->
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Дополнительные сведения</h4>
                                </div>
                                <!-- Основное содержимое модального окна -->
                                <div class="modal-body">
                                    <form id="update_form">

                                        <div class="form-group">
                                            <label for="exampleTextarea">Описание причин отмены</label>
                                            <textarea class="form-control"  id="description_view" rows="3" disabled></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleTextarea">Дата обработки</label>
                                            <input class="form-control"  id="updated_at" disabled>
                                        </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>


                                    </div>
                                </div>
                                <!-- Футер модального окна -->

                            </div>
                        </div>
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

    </script>
    <script>
        $(document).ready(function() {
            $("#myModalBox").modal('show');
        });
    </script>
@stop