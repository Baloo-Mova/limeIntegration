@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>   Админ. Список зарегистрованных пользователей
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">

                    <div>
                        {{--<a href="{{ route('admin.users.create') }}" class="btn btn-success center">Создать</a>--}}
                        <a href="{{ route('admin.users.export') }}" class="btn btn-primary center">Экспорт</a>
                    </div>

                    <hr/>


                    <div class="grid-view ">
                        <form action="{{ route('admin.users.find') }}" method="post">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                        {{ csrf_field() }}
                                        <th>
                                            <a href="#" class="btn btn-default reset">Очистить</a>
                                        </th>
                                        <th>
                                            <input type="text" name="name" class="form-control name" value="{{ isset($search['name']) ? $search['name'] : '' }}">
                                        </th>
                                        <th>
                                            <input type="text" name="second_name" class="form-control second_name" value="{{ isset($search['second_name']) ? $search['second_name'] : '' }}">
                                        </th>
                                        <th>
                                            <select name="role_id" id="" class="form-control role_id">
                                                <option disabled selected>Выберите права</option>
                                                <option value="1" {{ isset($search['role_id']) && $search['role_id'] == 1 ? 'selected' : '' }} >Пользователь</option>
                                                <option value="3" {{ isset($search['role_id']) && $search['role_id'] == 3 ? 'selected' : '' }} >Оператор</option>
                                            </select>
                                        </th>
                                        <th>
                                            <input type="text" name="email" class="form-control email" value="{{ isset($search['email']) ? $search['email'] : '' }}">
                                        </th>
                                        <th>
                                            <input type="text" name="balance" class="form-control balance" value="{{ isset($search['balance']) ? $search['balance'] : '' }}">
                                        </th>
                                        <th>
                                            <select name="country_id" id="" class="form-control country_id">
                                                <option disabled selected>Выберите страну</option>
                                                @forelse($countries as $country)
                                                    <option value="{{ $country->country_id }}" {{ isset($search['country_id']) && $search['country_id'] == $country->country_id ? 'selected' : '' }} >
                                                        {{ $country->title }}
                                                    </option>
                                                @empty
                                                    <option disabled selected>Нет стран</option>
                                                @endforelse
                                            </select>
                                        </th>
                                        <th>
                                            <input type="text" name="created_at" class="form-control date created_at" value="{{ isset($search['created_at']) ? $search['created_at'] : '' }}">
                                        </th>
                                        <th>
                                            <button type="submit" class="btn btn-success">Найти</button>
                                        </th>
                                </tr>
                            <tr>
                                <th>Id</th>
                                <th><a class="" href="#">Имя</a></th>
                                <th><a class="" href="#">Фамилия</a></th>
                                <th><a class="" href="#">Права</a></th>
                                <th><a class="" href="#">Почта</a></th>
                                <th><a class="" href="#">Баланс</a></th>
                                <th><a class="" href="#">Страна</a></th>

                                <th><a class="" href="#">Дата создания</a></th>
                                <th><a class="" href="#"></a></th>

                            </tr>

                            </thead>
                            <tbody class='text-center'>
                            @foreach($users as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->second_name}}</td>
                                    <td>{{$item->role->title}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->balance}}</td>
                                    <td>{{$item->country->title}}</td>
                                    <td>{{$item->created_at}}</td>

                                    <td>
                                        <a href="{{route('admin.users.show', [$item->id])}}" title="View"
                                           aria-label="View"
                                           data-pjax="0">
                                            <span class="fa fa-eye"></span>
                                        </a>

                                        <a href="{{route('admin.users.edit', [$item->id])}}" title="Update"
                                           aria-label="Update"
                                           data-pjax="0">
                                            <span class="fa fa-pencil"></span></a>

                                        <a href="{{ route('admin.users.delete', ['id'=>$item->id]) }}"
                                           title="Delete"
                                           aria-label="Delete"
                                           data-confirm="Вы точно хотите удалить этого пользователя?"
                                           data-method="post" data-pjax="0">
                                            <span class="fa fa-trash"></span>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        </form>
                    </div>

                    {!! $users->links() !!}

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $(".reset").on("click", function(){
                $(".name").val("");
                $(".second_name").val("");
                $(".role_id").val("");
                $(".email").val("");
                $(".balance").val("");
                $(".country_id").val("");
                $(".date").val("");
            });
            $('.date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'MM.DD.YYYY'
                }
            });

            $('.date').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM.DD.YYYY') + ' - ' + picker.endDate.format('MM.DD.YYYY'));
            });

            $('.date').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });

    </script>
@stop