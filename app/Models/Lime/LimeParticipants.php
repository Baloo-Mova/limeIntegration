<?php

namespace App\Models\Lime;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lime\LimeSurveyLinks;
use Illuminate\Support\Facades\DB;

/**
 * @property string $participant_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $language
 * @property string $blacklisted
 * @property integer $owner_uid
 * @property integer $created_by
 * @property string $created
 * @property string $modified
 */
class LimeParticipants extends Model
{
    protected $connection = 'mysql_lime';
    protected $table = 'participants';
    /**
     * @var array
     */

    protected $fillable = ['participant_id','firstname', 'lastname', 'email', 'language', 'blacklisted', 'owner_uid', 'created_by', 'created', 'modified'];

    static function gen_uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
    public function getSurveyLinks(){
        return $this->hasMany(LimeSurveyLinks::class,'participant_id','participant_id')
            ->join('surveys', 'survey_links.survey_id', '=', 'surveys.sid')->where(['surveys.active'=>'Y','surveys.type_id'=>0]);
    }
    public function getGlobalSurveyLinks(){
        return $this->hasMany(LimeSurveyLinks::class,'participant_id','participant_id')
            ->join('surveys', 'survey_links.survey_id', '=', 'surveys.sid')->where(['surveys.active'=>'Y',['surveys.type_id','<>',0]]);
    }
    public function checkCompleteSurvey($survey_id){
        try {
            $token = DB::connection('mysql_lime')->table("tokens_" . $survey_id)->where(['participant_id' => $this->participant_id,['completed','<>','N']])->orWhere(['email' =>$this->email,['completed','<>','N']])->first();
            if(isset($token)){
             return true;
            }
        }catch(\Exception $e){dd($e->getMessage());}
        return false;
    }

}
