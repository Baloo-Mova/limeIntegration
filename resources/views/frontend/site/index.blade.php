@extends('frontend.layouts.template')

@section('content')

<hr/>

<div class="content-area">
    <div class="container">
        <!-- About us panel -->
            <div class="row">
                
                    <h2>Опросы</h2>
                
            </div>
    <hr/>

        <div class="row">

            <div class="grid-view ">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>

                        <th><a class="" href="#">Название</a></th>
                        <th><a class="" href="#">Награждение </a></th>
                        <th><a class="" href="#">Статус</a></th>
                        <th><a class="" href="#"></a></th>

                    </tr>

                    </thead>
                    <tbody class='text-center'>
                    @foreach($surveys as $item)
                        <tr>

                            <td>{{$item->LimeSurveysLanguage->first()->surveyls_title}}</td>
                            <td>{{$item->reward}} ₽</td>
                            <td>

                            {{Auth::user()!=null ? ($item->getStatus(Auth::user()->email)) : Lang::get('messages.SurveyNotCompleted')}}


                            <td>
                                <a href="#" class="btn btn-danger" title="View" aria-label="View" data-pjax="0">
                                    <span class="fa fa-pensil">Пройти</span>
                                </a>



                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            {!! $surveys->links() !!}
        </div>
       
      

<!-- end container-->
</div>
<!-- end content area-->
@stop

@section('css')
@stop

@section('js')
<script>
   
</script>

@stop