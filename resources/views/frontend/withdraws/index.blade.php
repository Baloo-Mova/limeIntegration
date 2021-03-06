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


    </div>


@stop

@section('css')
@stop

@section('js')
    <script>

    </script>

@stop