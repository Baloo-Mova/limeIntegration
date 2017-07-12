@extends('adminlte::layouts.app')
@section('contentheader_title')
    <i class='fa fa-user'></i>  Админ. Добавление пользователя
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal">
                        {{ csrf_field() }}


                        <div class="col-md-offset-2">
                            <div class="col-md-10">
                                <div class="form-group {{ $errors->has('title')?'has-danger':'' }}">
                                    <label class="control-label" for="title">Название:<span
                                                class="form-required">*</span></label>
                                    <input type="text" value="{{ old('title') }}" name="title" class="form-control"
                                           id="title">

                                    @if($errors->has('title'))
                                        <span class="control-label"> {{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="col-md-offset-2">
                            <div class="col-md-10">
                                <div class="form-group {{ $errors->has('weight_global')?'has-danger':'' }}">
                                    <label class="control-label" for="weight_global">Вес:</label>
                                    <input type="number" value="{{ old('global_weight') }}" name="weight_global"
                                           class="form-control"
                                           id="weight_global">
                                    @if($errors->has('weight_global'))
                                        <span class="control-label"> {{ $errors->first('weight_global') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!--<div class="col-md-offset-2">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class="control-label" for="email">Логотип:</label>
                                    <input type="file" name="logo_file" class="form-control" id="logo">
                                </div>
                            </div>
                        </div>-->

                        <div class="col-md-offset-2">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input value="Подати" type="submit" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script type="text/javascript">

        $("#logo").fileinput({
            'showUpload': false,
            'previewFileType': 'any',
            'allowedFileTypes': ['image']

        });

    </script>

@stop
