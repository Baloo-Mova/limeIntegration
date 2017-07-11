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
            @if($surveys->count()!=0)
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

                            <td>{{$item->limesurvey->LimeSurveysLanguage->first()->surveyls_title}}</td>
                            <td>{{$item->limesurvey->reward}} ₽</td>
                            <td>
                            <? if (Auth::user() != null) {
                                $status = $item->limesurvey->GetStatus(Auth::user()->email);

                            }
                            ?>
                            {{Auth::user()!=null ? ($status!='N' ? (Lang::get('messages.SurveyCompleted'). ' ('. $status.')') :  Lang::get('messages.SurveyNotCompleted') ) : Lang::get('messages.SurveyNotCompleted')}}


                            <td>
                                <a href="{{config('lime.ls_baceurl').$item->survey_id.'?token='.$item->gettoken()}}"
                                   class="btn btn-{{$status!='N'? 'success' : 'danger'}}" title="View" aria-label="View" data-pjax="0">
                                    <span class="fa fa-pensil">{{$status!='N' ? Lang::get('messages.SurveyCompletedButton') : Lang::get('messages.SurveyNotCompletedButton')}}</span>
                                </a>



                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

            {!! $surveys->links() !!}
                @else
                <h3>   {{\Illuminate\Support\Facades\Lang::get('messages.noSurveys')}}</h3>
            @endif


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