@extends('frontend.layouts.template')

@section('content')

<hr/>

<div class="user-profiles container container-center"><h2>Профили</h2>
    <hr/>
    @if($surveys->count()!=0)
    <table class="table table-hover table-striped space">
        <thead>
        <tr>
            <th class="table-header">Название</th>
            <th class="table-header  no-on-mobile">Вознаграждение</th>
            <th class="table-header">Статус</th>
            <th class="table-header" style="width:8em;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($surveys as $item)
            <tr>

                <td>{{$item->limesurvey->LimeSurveysLanguage->first()->surveyls_title}}</td>
                <td class="reward-profiles">{{$item->limesurvey->reward}} ₽</td>
                <td>
                <? if (Auth::user() != null) {
                    $status = $item->limesurvey->GetStatus(Auth::user()->email);

                }
                ?>
                {{Auth::user()!=null ? ($status!='N' ? (Lang::get('messages.SurveyCompleted'). ' ('. $status.')') :  Lang::get('messages.SurveyNotCompleted') ) : Lang::get('messages.SurveyNotCompleted')}}


                <td>
                    <a href="{{config('lime.ls_baceurl').$item->survey_id.'?token='.$item->gettoken()}}"
                       class="btn btn-{{$status!='N'? 'finished' : 'danger'}} btn-block btn-lg">
                        {{$status!='N' ? Lang::get('messages.SurveyCompletedButton') : Lang::get('messages.SurveyNotCompletedButton')}}
                    </a>


                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

        {!! $surveys->links() !!}
    @else
        <h3>   {{\Illuminate\Support\Facades\Lang::get('messages.noSurveys')}}</h3>
    @endif

</div>


@stop

@section('css')
@stop

@section('js')
<script>
   
</script>

@stop