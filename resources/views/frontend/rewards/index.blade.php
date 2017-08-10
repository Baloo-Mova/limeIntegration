@extends('frontend.layouts.template')

@section('content')
<div class="user-profiles container container-center"><h2>История начислений:</h2>
    @if($balancelogs->count()!=0)
    <table class="table table-hover table-striped space charges-list table-condensed">
        <thead>
        <tr>

            <th class="table-header  no-on-mobile">Сумма</th>
            <th class="table-header">Операция</th>
            <th class="table-header">Тип</th>
            <th class="table-header">Статус</th>
            <th class="table-header">Дата</th>
        </tr>
        </thead>
        <tbody>
        @foreach($balancelogs as $item)
            <tr>
                <td>{{$item->balance_operation}} ₽</td>
                <td>{{$item->description}} </td>
                <td>{{$item->payment_type_id==0 ? \Illuminate\Support\Facades\Lang::get('messages.paymentstypeLocal') : $item->paymentstype->title}} </td>
                <td>{{$item->getStatusMessage() }} </td>
                <td>{{$item->created_at}} </td>
            </tr>
        @endforeach

        </tbody>
    </table>

        {!! $balancelogs->links() !!}
    @else
        <h3>{{\Illuminate\Support\Facades\Lang::get('messages.noSurveys')}}</h3>
    @endif

</div>


@stop

@section('css')
@stop

@section('js')
<script>

</script>

@stop