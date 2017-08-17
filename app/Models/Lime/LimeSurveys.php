<?php

namespace App\Models\Lime;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lime\LimeSurveysLanguageSettings;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Lime\LimeSurveys
 *
 * @property int $sid
 * @property int $owner_id
 * @property string|null $admin
 * @property string $active
 * @property string|null $expires
 * @property string|null $startdate
 * @property string|null $adminemail
 * @property string $anonymized
 * @property string|null $faxto
 * @property string|null $format
 * @property string $savetimings
 * @property string|null $template
 * @property string|null $language
 * @property string|null $additional_languages
 * @property string $datestamp
 * @property string $usecookie
 * @property string $allowregister
 * @property string $allowsave
 * @property int $autonumber_start
 * @property string $autoredirect
 * @property string $allowprev
 * @property string $printanswers
 * @property string $ipaddr
 * @property string $refurl
 * @property string|null $datecreated
 * @property string $publicstatistics
 * @property string $publicgraphs
 * @property string $listpublic
 * @property string $htmlemail
 * @property string $sendconfirmation
 * @property string $tokenanswerspersistence
 * @property string $assessments
 * @property string $usecaptcha
 * @property string $usetokens
 * @property string|null $bounce_email
 * @property string|null $attributedescriptions
 * @property string|null $emailresponseto
 * @property string|null $emailnotificationto
 * @property int $tokenlength
 * @property string|null $showxquestions
 * @property string|null $showgroupinfo
 * @property string|null $shownoanswer
 * @property string|null $showqnumcode
 * @property int|null $bouncetime
 * @property string|null $bounceprocessing
 * @property string|null $bounceaccounttype
 * @property string|null $bounceaccounthost
 * @property string|null $bounceaccountpass
 * @property string|null $bounceaccountencryption
 * @property string|null $bounceaccountuser
 * @property string|null $showwelcome
 * @property string|null $showprogress
 * @property int $questionindex
 * @property int $navigationdelay
 * @property int|0 $type_id
 * @property int|0 $reward
 * @property string|null $interests_tags
 * @property string|null $nokeyboard
 * @property string|null $alloweditaftercompletion
 * @property string|null $googleanalyticsstyle
 * @property string|null $googleanalyticsapikey
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAdditionalLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAdminemail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAlloweditaftercompletion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAllowprev($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAllowregister($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAllowsave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAnonymized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAssessments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAttributedescriptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAutonumberStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereAutoredirect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereBounceEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereBounceaccountencryption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereBounceaccounthost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereBounceaccountpass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereBounceaccounttype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereBounceaccountuser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereBounceprocessing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereBouncetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereDatecreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereDatestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereEmailnotificationto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereEmailresponseto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereExpires($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereFaxto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereGoogleanalyticsapikey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereGoogleanalyticsstyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereHtmlemail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereIpaddr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereListpublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereNavigationdelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereNokeyboard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys wherePrintanswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys wherePublicgraphs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys wherePublicstatistics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereQuestionindex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereRefurl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereSavetimings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereSendconfirmation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereShowgroupinfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereShownoanswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereShowprogress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereShowqnumcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereShowwelcome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereShowxquestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereSid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereStartdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereTokenanswerspersistence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereTokenlength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereUsecaptcha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereUsecookie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Lime\LimeSurveys whereUsetokens($value)
 * @mixin \Eloquent
 */
class LimeSurveys extends Model
{
    protected $connection = 'mysql_lime';
    protected $table = 'surveys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sid',
        'ownder_id',
        'admin',
        'active',
        'expires',
        'startdate',
        'adminemail',
        'anonymized',
        'format',
        'savetimings',
        'template',
        'language',
        'additional_languages',
        'datestamp',
        'usecookie',
        'allowregister',
        'allowsave',
        'autonumber_start',
        'autoredirect',
        'allowprev',
        'printanswers',
        'ipaddr',
        'refurl',
        'datecreated',
        'publicstatistics',
        'publicgraphs',
        'listpublic',
        'htmlemail',
        'sendconfirmation',
        'tokenanswerspersistence',
        'assessments',
        'usecaptcha',
        'usetokens',
        'bounce_email',
        'attributedescriptions',
        'emailresponseto',
        'emailnotificationto',
        'tokenlength',
        'showxquestions',
        'showgroupinfo',
        'shownoanswer',
        'showqnumcode',
        'bouncetime',
        'bounceprocessing',
        'bounceaccounttype',
        'bounceaccountpass',
        'bounceaccountencryption',
        'bounceaccountuser',
        'showwelcome',
        'showprogress',
        'questionindex',
        'navigationdelay',
        'nokeyboard',
        'alloweditaftercompletion',
        'googleanalyticsstyle',
        'googleanalyticsapikey',
        'type_id',
        'reward',
        'interests_tags',
    ];

    /**
     * @return mixed
     */
    public function LimeSurveysLanguage()
    {
        return $this->hasOne(LimeSurveysLanguageSettings::class, 'surveyls_survey_id', 'sid');
    }

    public function Questions()
    {
        return $this->hasMany(LimeSurveysQuestions::class, 'sid', 'sid');
    }

    public function GetStatus($search)
    {
        try {
            $tokens = DB::connection('mysql_lime')->table("tokens_" . $this->sid)->where(['participant_id' => $search])->first();
        } catch (\Exception $e) {
        }
        return isset($tokens) ? $tokens->completed : null;

    }

    public function getWorksheet()
    { // Анкеты
        return $this->belongsTo(LimeSurveys::class, 'survey_id', 'sid')->where(['language' => Lang::getLocale(), 'active' => 'Y']);
    }

    public function getQuotes()
    {
        return $this->hasMany(LimeSurveysQuotes::class, 'sid', 'sid');
    }
    /*public function scopeAllWorksheets($query)
    {
        return $query->where(['type_id' => 0]);
    }*/

}
