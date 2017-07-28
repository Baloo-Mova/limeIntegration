@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center"><h2>Сообщения</h2>
        <hr/>
        <table class="table table-hover table-striped space">
            <thead>
            <tr>
                <th class="table-header">Сообщение</th>
                <th class="table-header">Статус</th>
                <th class="table-header" style="width:8em;">Действия</th>
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
                            {{ $message->read_at == null ? "Новое сообщение" : "Прочитано"}}
                        </td>
                        <td>
                            <a href="{{route('messages.show', ['mid' => $message->id])}}" title="Просмотреть полностью"
                               aria-label="Update"
                               data-pjax="0">
                                <span class="fa fa-eye"></span>
                            </a>
                        </td>
                    </tr>
                    @endif
                @empty
                    <td class="text-center">
                        <p>Нет новых сообщений</p>
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