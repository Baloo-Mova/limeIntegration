<?php

namespace App\Models\Lime;

use Illuminate\Database\Eloquent\Model;

class LimeSurveysQuestions extends Model
{
    protected $connection = 'mysql_lime';
    protected $table = 'questions';

    public function Answers(){
        return $this->hasMany(LimeSurveysQuestionsAnswers::class, 'qid', 'qid');
    }

}
