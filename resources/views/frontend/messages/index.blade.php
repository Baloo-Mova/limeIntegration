@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center"><h2>@lang('messages.messages_page_title')</h2>
        <hr/>
        <table class="table table-hover table-striped space">
            <thead>
            <tr>
                <th class="table-header">@lang('messages.messages_page_table_message')</th>
                <th class="table-header">@lang('messages.messages_page_table_status')</th>
                <th class="table-header" style="width:8em;">@lang('messages.messages_page_table_actions')</th>
            </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    @if($message->type == "App\Notifications\SendMessage")
                    <tr>
                        <td>
                            <div class="short_text">
                                {{ $message->data["data"]["message"] }}
                            </div>
                        </td>
                        <td>
                            {{ $message->read_at == null ? Lang::get('messages.newMessage'): Lang::get('messages.readed')}}
                        </td>
                        <td>
                            <a href="{{route('messages.show', ['mid' => $message->id])}}" title="@lang('messages.see_all')"
                               aria-label="Update"
                               data-pjax="0">
                                <span class="fa fa-eye"></span>
                            </a>
                        </td>
                    </tr>
                    @endif
                @empty
                    <td class="text-center">
                        <p>@lang('messages.no_new_messages')</p>
                    </td>
                @endforelse

            </tbody>
        </table>
    </div>


        @stop

        @section('css')
        @stop

        @section('js')
            <script>

            </script>

@stop