@extends('frontend.layouts.template')

@section('content')
    <hr/>
    <div class="page-title text-center">
        <h2>Админ. Изменение системы платежа. Идентификационный номер: {{$paymentstype->id}}</h2>
    </div>
    <hr/>
    <div class="container">
        <form method="POST" enctype="multipart/form-data" class="form-horizontal">
            {{ csrf_field() }}




            <div class="col-md-offset-2">
                <div class="col-md-10">
                    <div class="form-group {{ $errors->has('title')?'has-danger':'' }}">
                        <label class="control-label" for="title">Название:<span class="form-required">*</span></label>
                        <input type="text" value="{{$paymentstype->title}}" name="title" class="form-control" id="title">

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
                        <input type="number" value="{{$paymentstype->weight_global}}" name="weight_global" class="form-control"
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
                        <input value="Обновить" type="submit" class="btn btn-success">
                    </div>
                </div>
            </div>
        </form>
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