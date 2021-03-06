@extends('frontend.layouts.template')

@section('content')
    <div class="user-profiles container container-center"><h2>@lang('messages.profile_page_title')</h2>
        <div class="user_info">
            <table class="table table-striped">
                <tr>
                    <td>@lang('messages.profile_page_table_name')</td>
                    <td>{{ $user_info->name." ".$user_info->second_name }}</td>
                </tr>
                <tr>
                    <td>@lang('messages.profile_page_table_email')</td>
                    <td>{{ $user_info->email }}</td>
                </tr>
                <tr>
                    <td>@lang('messages.profile_page_table_gender')</td>
                    <td>{{ $user_info->gender == 0 ? "Мужской" : "Женский" }}</td>
                </tr>
                <tr>
                    <td>@lang('messages.profile_page_table_country')</td>
                    <td>{{ isset($user_info->country_id) ? $user_info->country->title : " не указана" }}</td>
                </tr>
                <tr>
                    <td>@lang('messages.profile_page_table_region')</td>
                    <td>{{ isset($region) ? $region->title : " не указана" }}</td>
                </tr>
                <tr>
                    <td>@lang('messages.profile_page_table_city')</td>
                    <td>{{ isset($city) ? $city->title : " не указан" }}</td>
                </tr>
                <tr>
                    <td>@lang('messages.profile_page_table_birthday')</td>
                    <td>{{ isset($user_info->date_birth) ? date_format(date_create($user_info->date_birth),'d-m-Y') : " не указана" }}</td>
                </tr>
            </table>
        </div>
        <hr/>
        @if(count($surveys) > 0)
        <table class="table table-hover table-striped space">
            <thead>
            <tr>
                <th class="table-header">@lang('messages.profile_page_table2_name')</th>
                <th class="table-header  no-on-mobile">@lang('messages.profile_page_table2_reward')</th>
                <th class="table-header">@lang('messages.profile_page_table2_status')</th>
                <th class="table-header" style="width:8em;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($surveys as $item)
                <tr>
                    <td>{{$item->limesurvey->LimeSurveysLanguage->surveyls_title}}</td>
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
            <h3>{{\Illuminate\Support\Facades\Lang::get('messages.noWorksheets')}}</h3>
        @endif
    </div>


        @stop

        @section('css')
        @stop

        @section('js')
            <script>

            </script>

@stop