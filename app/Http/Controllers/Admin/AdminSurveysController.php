<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lime\LimeSurveys;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class AdminSurveysController extends Controller
{
    public function index()
    {
        $surveys = LimeSurveys::paginate(10);
        return view('admin.surveys.index', with([
            'surveys' => $surveys
        ]));
    }
    public function convertToWorksheet($sid, $type)
    {
        $survey = LimeSurveys::where(['sid' => $sid])->first();

        if(!isset($survey)){
            return back();
        }

        $lime_base = DB::connection('mysql_lime');
        $lime_base->table('surveys')->where('sid', $sid)->update(['type_id' => $type]);

        return back();
    }

    public function changeReward(Request $request)
    {
        $sid = $request->get('sid');
        $money = $request->get('money');

        if(!isset($sid) || !isset($money)){
            Toastr::error('Не указан обязательный параметр!', 'Ошибка');
            return back();
        }

        $survey = LimeSurveys::where(['sid' => $sid])->first();

        if(!isset($survey)){
            Toastr::error('Опрос не найден!', 'Ошибка');
            return back();
        }

        $lime_base = DB::connection('mysql_lime');
        $lime_base->table('surveys')->where('sid', $sid)->update(['reward' => $money]);

        Toastr::success('Сумма вознаграждения изменена', 'Сохранено!');
        return back();
    }
}
