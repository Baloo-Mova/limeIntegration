<?php


namespace App\Models\Lime;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lime\LimeSurveys;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

/**
 * @property string $participant_id
 * @property integer $token_id
 * @property integer $survey_id
 * @property string $date_created
 * @property string $date_invited
 * @property string $date_completed
 */
class LimeSurveyLinks extends Model
{
    protected $connection = 'mysql_lime';
    protected $table = 'survey_links';
    /**
     * @var array
     */
    protected $fillable = ['participant_id','token_id','survey_id','date_created', 'date_invited', 'date_completed'];

    public function limesurvey(){
        return $this->belongsTo(LimeSurveys::class,'survey_id','sid')->where(['language'=>Lang::getLocale(),'active'=>'Y'] );
    }
    public function gettoken(){
        try{
            $token = DB::connection('mysql_lime')->table("tokens_" . $this->survey_id)->where(['participant_id' => $this->participant_id,['token','<>',null]])->first();

        }catch (\Exception $ex){
        }
        return isset($token) ? $token->token : null;
    }
}
