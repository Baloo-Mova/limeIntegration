<?php

namespace App\Models\Lime;

use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Lime\LimeSurveysLanguageSettings
 *
 * @property int $surveyls_survey_id
 * @property string $surveyls_language
 * @property string $surveyls_title
 * @property string|null $surveyls_description
 * @property string|null $surveyls_welcometext
 * @property string|null $surveyls_endtext
 * @property string|null $surveyls_url
 * @property string|null $surveyls_urldescription
 * @property string|null $surveyls_email_invite_subj
 * @property string|null $surveyls_email_invite
 * @property string|null $surveyls_email_remind_subj
 * @property string|null $surveyls_email_remind
 * @property string|null $surveyls_email_register_subj
 * @property string|null $surveyls_email_register
 * @property string|null $surveyls_email_confirm_subj
 * @property string|null $surveyls_email_confirm
 * @property int $surveyls_dateformat
 * @property string|null $surveyls_attributecaptions
 * @property string|null $email_admin_notification_subj
 * @property string|null $email_admin_notification
 * @property string|null $email_admin_responses_subj
 * @property string|null $email_admin_responses
 * @property int $surveyls_numberformat
 * @property string|null $attachments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereEmailAdminNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereEmailAdminNotificationSubj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereEmailAdminResponses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereEmailAdminResponsesSubj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsAttributecaptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsDateformat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEmailConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEmailConfirmSubj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEmailInvite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEmailInviteSubj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEmailRegister($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEmailRegisterSubj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEmailRemind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEmailRemindSubj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsEndtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsNumberformat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsUrldescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveysLanguageSettings whereSurveylsWelcometext($value)
 * @mixin \Eloquent
 */
class LimeSurveysLanguageSettings  extends Model
{
    protected $connection = 'mysql_lime';
    protected $table = 'surveys_languagesettings';
public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surveyls_survey_id',
        'surveyls_language',
        'surveyls_title',
        'surveyls_description',
        'surveyls_welcometext',
        'surveyls_endtext',
        'adminemail',
        'surveyls_url',
        'surveyls_urldescription',
        'surveyls_email_invite_subj',
        'surveyls_email_invite',
        'surveyls_email_remind_subj',
        'surveyls_email_remind',
        'surveyls_email_register_subj',
        'surveyls_email_register',
        'surveyls_email_confirm_subj',
        'surveyls_email_confirm',
        'surveyls_dateformat',
        'surveyls_attributecaptions',
        'email_admin_notification_subj',
        'email_admin_notification',
        'email_admin_responses_subj',
        'email_admin_responses',
        'surveyls_numberformat',
        'attachments',

    ];



}
