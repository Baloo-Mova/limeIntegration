@extends('admin.layouts.template')

@section('content')
    <hr/>

    <div class="page-title text-center">
        <h2>Админ. Просмотр Пользователя. Идентификационный номер: {{$paymentstype->id}}</h2>
    </div>
    <hr/>

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-block">
                <div class="media">
                    <div class="media-left media-middle">
                        <a href="#">
                            <img class="media-object" src="http://dummyimage.com/150x150" alt="...">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5>Нaзвание: {{$paymentstype->title}}</h5>
                        <p>Создано: {{$paymentstype->created_at}}</p>
                        <p>Вес: {!! $paymentstype->weight_global !!}</p>
                        <div class="btn-toolbar">

                            <div class="btn-group">
                                <a href="{{ route('admin.paymentstypes.edit', ['id'=>$paymentstype->id]) }}"
                                   class="btn-primary btn">Обновить</a>
                            </div>
                            <div class="btn-group">
                                <a href="{{ route('admin.paymentstypes.delete', ['id'=>$paymentstype->id]) }}"
                                   onclick="return confirm('Вы точно хотите удалить єту систему')"
                                   class="btn-danger btn">Удалить</a>
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

@stop
