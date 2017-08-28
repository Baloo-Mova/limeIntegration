@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center"><h2>@lang('messages.balance_page_title')</h2>
        <hr/>
        <div class="row">
            <div class="lead col-xs-4 col-sm-6 col-md-8"><span>@lang('messages.balance_page_available')</span>
                <span class="label label-success">{{Auth::user()->balance}}</span></div>
            <div class="col-xs-8 col-sm-6 col-md-4 text-right">

            </div>
        </div>

        <div class="row">
            @if(Auth::user()->balance < $min_sum)
                <div class="lead col-xs-12 col-sm-12 col-md-12 text-danger">
                    @lang('messages.balance_page_message1') <b>{{$min_sum}}</b>.

                    @lang('messages.balance_page_message2') <b>{{$min_sum-Auth::user()->balance}}</b>.
                    <br>
                    @lang('messages.balance_page_message3')
                </div>
            @else
                <div class="col-xs-12">
                    <h3>Создать заявку на вывод средств</h3>
                    <div class="col-xs-6">
                        <form method="POST" enctype="multipart/form-data" class="form-horizontal"
                              action="{{ route('withdraws.store') }}">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('destination')?'has-error':'' }}">
                                <label class="control-label" for="destination">Назначение (номер карты,
                                    телефона или
                                    другие реквизиты):<span class="form-required">*</span></label>
                                <input type="text" value="{{ old('destination') }}" name="destination"
                                       class="form-control"
                                       id="destination">

                                @if($errors->has('destination'))
                                    <span class="control-label"> {{ $errors->first('destination') }}</span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('paymentstype') ? ' has-error' : '' }}">
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
                            <div class="form-group {{ $errors->has('amount')?'has-error':'' }}">
                                <label class="control-label" for="amount">Сумма:</label>
                                <input type="number" value="{{ old('amount') }}" name="amount"
                                       class="form-control"
                                       id="weight_global">
                                @if($errors->has('amount'))
                                    <span class="control-label"> {{ $errors->first('amount') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input value="Подати" type="submit" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="col-xs-12">
                @if($balancelogs->count()!=0)
                    <table class="table table-hover table-striped space charges-list table-condensed">
                        <thead>
                        <tr>

                            <th class="table-header no-on-mobile">@lang('messages.rewards_page_table_sum')</th>
                            <th class="table-header no-on-mobile">@lang('messages.rewards_page_table_destination')</th>
                            <th class="table-header">@lang('messages.rewards_page_table_type')</th>
                            <th class="table-header">@lang('messages.rewards_page_table_status')</th>
                            <th class="table-header">@lang('messages.rewards_page_table_date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($balancelogs as $item)
                            <tr>
                                <td>{{$item->amount}}</td>
                                <td>{{$item->destination}}</td>
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
        </div>
    </div>
@stop