<?php

namespace App\Models\Lime;

use Illuminate\Database\Eloquent\Model;

class LimeSurveysQuestionsAnswers extends Model
{
    protected $connection = 'mysql_lime';
    protected $table = 'answers';
}
