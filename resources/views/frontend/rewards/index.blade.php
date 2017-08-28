@extends('frontend.layouts.template')

@section('content')
<div class="user-profiles container container-center"><h2>@lang('messages.rewards_page_title')</h2>
    @if($balancelogs->count()!=0)
    <table class="table table-hover table-striped space charges-list table-condensed">
        <thead>
        <tr>
            <th class="table-header no-on-mobile">@lang('messages.rewards_page_table_sum')</th>
            <th class="table-header">@lang('messages.rewards_page_table_operation')</th>
            <th class="table-header">@lang('messages.rewards_page_table_type')</th>
            <th class="table-header">@lang('messages.rewards_page_table_status')</th>
            <th class="table-header">@lang('messages.rewards_page_table_date')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($balancelogs as $item)
            <tr>
                <td>{{$item->balance_operation}}</td>
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
        <h3>{{\Illuminate\Support\Facades\Lang::get('messages.historyPaidClear')}}</h3>
    @endif

</div>


@stop

@section('css')
@stop

@section('js')
<script>

</script>

@stop