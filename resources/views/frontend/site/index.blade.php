@extends('frontend.layouts.template')

@section('content')
<div class="user-profiles container container-center">
    <h2>@lang('messages.surveys_page_title')</h2>
    @if(count($surveys)!=0)
    <table class="table table-hover table-striped space">
        <thead>
        <tr>
            <th class="table-header">@lang('messages.surveys_page_table_name')</th>
            <th class="table-header  no-on-mobile">@lang('messages.surveys_page_table_reward')</th>
            <th class="table-header">@lang('messages.surveys_page_table_status')</th>
            <th class="table-header" style="width:8em;">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($surveys as $item)
            <tr>
                <td>{{$item->limesurvey->LimeSurveysLanguage->first()->surveyls_title}}</td>
                <td class="reward-profiles">{{$item->limesurvey->reward}} ₽</td>
                <td>
                <?php
                    if (Auth::user() != null) {
                        $status = $item->limesurvey->GetStatus(Auth::user()->participant->participant_id);
                    }
                ?>
                {{Auth::user()!=null ? ($status!='N' ? (Lang::get('messages.SurveyCompleted'). ' ('. $status.')') :  Lang::get('messages.SurveyNotCompleted') ) : Lang::get('messages.SurveyNotCompleted')}}

                <td>
                    <a href="{{url('/gotosurvey/'.$item->survey_id.'/'.$item->gettoken())}}"
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
        <h3> @lang('messages.surveys_page_no_surveys')</h3>
    @endif

</div>


@stop

@section('css')
@stop

@section('js')
<script>
   
</script>

@stop