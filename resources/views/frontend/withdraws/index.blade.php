@extends('frontend.layouts.template')

@section('content')

    <hr/>

    <div class="user-profiles container container-center"><h2>Заявки на вывод средств</h2>
        <hr/>
        <div class="row  space">
            <div class="lead col-xs-4 col-sm-6 col-md-8"><span>Доступно: </span>
                <span class="label label-success">{{Auth::user()->balance}} ₽</span></div>

        </div>
        <div class="row">
            <div class="lead col-xs-12 col-sm-12 col-md-12 text-danger">Минимальная сумма
                для создания заявки на вывод денег составляет <b>500&nbsp;₽</b>. Вам необходимо набрать еще
                <b>{{500-Auth::user()->balance}}&nbsp;₽</b>.
            </div>
        </div>
        <div class="row">
            <h2>Подать</h2>
            <form method="POST" enctype="multipart/form-data" class="form-horizontal"
                  action="{{ route('withdraws.store') }}">
                {{ csrf_field() }}


                <div class="col-md-offset-2">
                    <div class="col-md-10">
                        <div class="form-group {{ $errors->has('destination')?'has-danger':'' }}">
                            <label class="control-label" for="destination">Назначение (Укажите номер карты, телефона или
                                другие реквизиты):<span class="form-required">*</span></label>
                            <input type="text" value="{{ old('destination') }}" name="destination" class="form-control"
                                   id="destination">

                            @if($errors->has('destination'))
                                <span class="control-label"> {{ $errors->first('destination') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-2">
                    <div class="col-md-10">
                        <div class="form-group{{ $errors->has('paymentstype') ? ' has-danger' : '' }}">

                            <label for="paymentstype" class="col-form-label">Способ вывода</label>
                            <select class="form-control" id="paymentstype" name="paymentstype">

                                @forelse($paymentstypes as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @empty
                                    <option selected>Нет</option>
                                @endforelse
                            </select>
                            @if ($errors->has('paymentstype'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('paymentstype') }}</strong>
                                    </span>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-offset-2">
                    <div class="col-md-10">
                        <div class="form-group {{ $errors->has('amount')?'has-danger':'' }}">
                            <label class="control-label" for="amount">Сумма:</label>
                            <input type="number" value="{{ old('amount') }}" name="amount" class="form-control"
                                   id="weight_global">
                            @if($errors->has('amount'))
                                <span class="control-label"> {{ $errors->first('amount') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!--<div class="col-md-offset-2">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="control-label" for="email">Логотип:</label>
                            <input type="file" name="logo_file" class="form-control" id="logo">
                        </div>
                    </div>
                </div>-->

                <div class="col-md-offset-2">
                    <div class="col-md-10">
                        <div class="form-group">
                            <input value="Подати" type="submit" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
        <hr/>
            <table class="table table-hover table-striped space charges-list table-condensed">
                <thead>
                <tr>
                    <th class="table-header">Назначение</th>
                    <th class="table-header">Сумма</th>
                    <th class="table-header">Описание</th>
                    <th class="table-header">Тип</th>
                    <th class="table-header">Статус</th>
                    <th class="table-header">Дата</th>
                </tr>
                </thead>
                <tbody>
                @foreach($withdraws as $item)
                    <tr>

                        <td>{{$item->destination}}</td>
                        <td>{{$item->amount}} ₽</td>
                        <td>{{$item->description}} </td>
                        <td>{{$item->payment_type_id==0 ? \Illuminate\Support\Facades\Lang::get('messages.paymentstypeLocal') : $item->paymentstype->title}} </td>
                        <td>{{$item->getStatusMessage() }} </td>
                        <td>{{$item->created_at}} </td>


                    </tr>
                @endforeach

                </tbody>
            </table>

            {!! $withdraws->links() !!}
        </div>

    </div>


@stop

@section('css')
@stop

@section('js')
    <script>

    </script>

@stop