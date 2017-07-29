@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>   Добавить пользователей к опросу
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <form action="" method="post">
                        {{ csrf_field() }}
                        <div class="col-md-4">
                                <div class="col-xs-12 ">
                                    <div class="form-group">
                                        <label for="survey" class="control-label">Опрос</label>
                                        <select name="survey" id="" class="form-control">
                                            <option value="" disabled selected>Выберите опрос</option>
                                            @forelse($surveys as $survey)
                                                <option value="{{ $survey->sid }}" >{{ $survey->LimeSurveysLanguage->first()->surveyls_title }}</option>
                                            @empty
                                                <option value="" disabled>Опросов нет</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            <div class="col-xs-12 ">
                                <div class="form-group">
                                    <label for="participants" class="control-label">Участники</label>
                                    <textarea name="participants" class="form-control" id="participants" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                                <div class="col-xs-6 ">
                                    <button type="submit" class="btn btn-success btn-block mt10">
                                        Добавить
                                    </button>
                                </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop