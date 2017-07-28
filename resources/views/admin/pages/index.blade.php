@extends('adminlte::layouts.app')
@section('contentheader_title')
    Админ. Страницы сайта
@endsection

@section('main-content')

    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div>
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-success center">Добавить</a>
                    </div>

                    <hr/>


                    <div class="grid-view">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                            <tr>
                                <th><a class="" href="#">Название</a></th>
                                <th>Действия</th>
                            </tr>

                            </thead>
                            <tbody class='text-center'>
                                @forelse($pages as $page)
                                    <tr>
                                        <td>
                                            {{ $page->title }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pages.show', ['id' => $page->id]) }}" title="View"
                                               aria-label="View"
                                               data-pjax="0">
                                                <span class="fa fa-eye"></span>
                                            </a>

                                            <a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}" title="Update"
                                               aria-label="Update"
                                               data-pjax="0">
                                                <span class="fa fa-pencil"></span></a>

                                            <a href="{{ route('admin.pages.delete', ['id' => $page->id]) }}"
                                               title="Delete"
                                               aria-label="Delete"
                                               data-confirm="Вы точно хотите удалить эту страницу?"
                                               data-method="post" data-pjax="0">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="2">
                                            <p>Страницы не найдены!</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop